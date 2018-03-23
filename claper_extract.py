#!/usr/bin/python
# -*- coding: utf-8 -*-
import re
import json
import argparse
from pprint import pprint, pformat
from progressbar import *
import subprocess
from slugify import slugify
from datetime import datetime
import pymongo
from pymongo import MongoClient
from collections import OrderedDict
from bson import BSON
from bson.son import SON
from bson.codec_options import CodecOptions

client = MongoClient('localhost', 27017)
db = client.biblat
articulo = db.articulo.with_options(codec_options=CodecOptions(document_class=OrderedDict))
cat_history = db.cat_history.with_options(codec_options=CodecOptions(document_class=OrderedDict))

db2 = client.biblat_old
articulo2 = db2.articulo.with_options(codec_options=CodecOptions(document_class=OrderedDict))
cat_history2 = db2.cat_history.with_options(codec_options=CodecOptions(document_class=OrderedDict))


parser = argparse.ArgumentParser()
parser.add_argument('-range', action='store_true', default=False, dest='scielo_range', help='Print scielo range list')
parser.add_argument('-noclase', action='store_false', default=True, dest='clase', help='No parse clase db')
parser.add_argument('-noperiodica', action='store_false', default=True, dest='periodica', help='No parse periodica db')
parser.add_argument('-scielo', action='store_true', default=False, dest='scielo', help='Parse sciel rage in periodica')
arguments = parser.parse_args()

'''Inicializando variables para almacenar las etiquetas del registro y el registro actual'''
pbar = None
progress = 0
registro = OrderedDict()
registro_marc = OrderedDict()
current = ""
tags = ['008', '022', '024', '035', '036', '039', '041', '100', '110', '120', '222', '245', '260', '300', '504', '520', '546', '590', '650', '653', '654', '698', '856', 'CAT']
json_tags = ('100', '110', '120', '300', '520', '590')
tags_article = [
    ('sistema', '035'),
    ('revista', '222'),
    ('titulo', '245'),
    ('issn', '022'),
    ('doi', '024'),
    ('paisRevista', '008'),
    ('fechaIngreso', '036'),
    ('idioma', '041'),
    ('anioRevista', '260'),
    ('descripcionBibliografica', '300'),
    ('resumen', '520'),
    ('idiomaResumen', '546'),
    ('documento', '590'),
    ('disciplinaRevista', '698'),
    ('disciplinas', '650'),
    ('palabraClave', '653'),
    ('keyword', '654'),
    ('url', '856')
]
fields_author = [
    ('nombre', 'a'),
    ('email', '6'),
    ('institucionId', 'z')
]
fields_institution = [
    ('id', 'z'),
    ('institucion', 'u'),
    ('dependencia', 'v'),
    ('ciudad', 'w'),
    ('pais', 'x')
]
fields_catalogador = [
    ('nombre', 'a'),
    ('nivel', 'b'),
    ('fechaEdicion', 'c'),
    ('horaEdicion', 'h')
]
len_tags = len(tags)

'''Patrones compilados'''
recordPattern = re.compile(r'(^[0-9]{9})\s([0-9]{3}|CAT).{3}L\s(.+?$)')
elValPattern = re.compile(r'(.)(.*?$)')
quotePattern = re.compile(r"'")
bslashPattern = re.compile(r"\\")
secuencePattern = re.compile(r"^\(([0-9]+?)\)$")

'''Abrimos archivos para guradar los resultados'''
detalles = open('./database/claperDetalles.txt', 'w')
fClaPerJSON = open('./database/claperJSON.txt', 'w')
fArticle = open('./database/articuloCLAPER.txt', 'w')
fAuthor = open('./database/autorCLAPER.txt', 'w')
fInstitution = open('./database/institucionCLAPER.txt', 'w')
fCatalogador = open('./database/catalogadorCLAPER.txt', 'w')

'''Abrimos archivos para guradar los resultados SIIA'''
fArticleSIIA = open('./database/articuloCLAPER-SIIA.txt', 'w')
fAuthorSIIA = open('./database/autorCLAPER-SIIA.txt', 'w')
fInstitutionSIIA = open('./database/institucionCLAPER-SIIA.txt', 'w')
fCatalogadorSIIA = open('./database/catalogadorCLAPER-SIIA.txt', 'w')

fArticleSIIADiff = open('./database/articuloCLAPER-SIIA.diff', 'w')
fAuthorSIIADiff = open('./database/autorCLAPER-SIIA.diff', 'w')
fInstitutionSIIADiff = open('./database/institucionCLAPER-SIIA.diff', 'w')
fCatalogadorSIIADiff = open('./database/catalogadorCLAPER-SIIA.diff', 'w')

fArticleSIIANew = open('./database/articuloCLAPER-SIIA.new', 'w')
fAuthorSIIANew = open('./database/autorCLAPER-SIIA.new', 'w')
fInstitutionSIIANew = open('./database/institucionCLAPER-SIIA.new', 'w')
fCatalogadorSIIANew = open('./database/catalogadorCLAPER-SIIA.new', 'w')

def monthdelta(date, delta):
    m, y = (date.month+delta) % 12, date.year + ((date.month)+delta-1) // 12
    if not m: m = 12
    d = min(date.day, [31,
        29 if y%4==0 and not y%400==0 else 28,31,30,31,30,31,31,30,31,30,31][m-1])
    return date.replace(day=d,month=m, year=y)


NOW = datetime.now()
DIFF_DATE = monthdelta(datetime.strptime('%d%02d%02d' % (NOW.year, NOW.month, 1), "%Y%m%d"), -1)
# DIFF_DATE = datetime.strptime('%d%02d%02d' % (NOW.year, NOW.month-2, 1), "%Y%m%d")
# print DIFF_DATE
# exit()

def biblat_make_index():
    articulo.create_index([("008.e", pymongo.ASCENDING)])
    articulo.create_index([("022.a", pymongo.ASCENDING)])
    articulo.create_index([("222.a", pymongo.ASCENDING)])
    articulo.create_index([("120.a", pymongo.ASCENDING)])
    articulo.create_index([("120.x", pymongo.ASCENDING)])

def duplicate_aff(tag, compare):
    '''Funcion para comparar la afiliación del autor esta duplicada'''
    del compare['z']
    for afiliation in tag:
        if 'z' in afiliation:
            del afiliation['z']
        print cmp(afiliation, compare)
        if cmp(afiliation, compare) == 0:
            return True
    return False


def add_record():
    '''Funcion para agregar el registro'''

    global registro, registro_marc, pbar, progress
    procesar_siia = False

    # pprint(registro)
    # print "≠" * 80
    # pprint(registro_marc)
    # raw_input("Press Enter to continue...")

    csv = ""
    '''Ajustamos los autores con su institución'''
    if '100' in registro and '120' in registro and '120in100' in registro and len(registro['100']) > 1:
        if len(registro['100']) == len(registro['120']) or len(registro['100']) < len(registro['120']):
            for i in range(0, len(registro['100'])):
                registro['100'][i].update({'z': '(%d)' % (i+1)})
        elif len(registro['100']) > len(registro['120']):
            registro['100'][0].update({'z': '(1)'})
        del registro['120in100']

    '''Verificamos si hay registros de la UNAM'''
    if '120' in registro:
        for institucion in registro['120']:
            if 'u' in institucion and slugify(institucion['u']) == "universidad-nacional-autonoma-de-mexico":
                procesar_siia = True
                break

    '''Asignamos la fecha de actualización'''
    last_update = registro['CAT'][-1]
    create_date = registro['CAT'][0]
    last_update = datetime(int(last_update['c'][:4]), int(last_update['c'][4:6]), int(last_update['c'][6:]), int(last_update['h'][:2]), int(last_update['h'][2:4]), int(last_update['h'][4:] or 0))
    create_date = datetime(int(create_date['c'][:4]), int(create_date['c'][4:6]), int(create_date['c'][6:]), int(create_date['h'][:2]), int(create_date['h'][2:4]), int(create_date['h'][4:] or 0))

    registro_marc['created_at'] = create_date
    registro_marc['updated_at'] = last_update

    '''Agregamos los registros de documentos'''
    tag_offset = 1
    len_fields = len(tags_article)
    for key, tag in tags_article:
        if tag in registro:
            '''Si el tamaño de la etiqueta es > 1 asignamos el primer elemento de la lista a la etiqueta'''
            if len(registro[tag]) > 1 and tag not in ('100', '110', '120', '520', '650', '653', '654', '856'):
                detalle = {'035': registro['035'], tag: registro[tag]}
                for line in registro[tag]:
                    detalles.write('%s %s   L $$a%s\n' % (registro['035'], tag, line))
                if len(registro[tag]) == 2:
                    if all(key in registro[tag] for key in ['Español', 'Inglés']):
                        detalles.write('%s %s   L $$aEspañol, inglés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Español', 'Francés']):
                        detalles.write('%s %s   L $$aEspañol, francés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Español', 'Portugués']):
                        detalles.write('%s %s   L $$aEspañol, portugués\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Inglés', 'Portugués']):
                        detalles.write('%s %s   L $$aPortugués, inglés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Inglés', 'Francés']):
                        detalles.write('%s %s   L $$aInglés, francés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Portugués', 'Francés']):
                        detalles.write('%s %s   L $$aPortugués, francés\n' % (registro['035'], tag))
                    else:
                        '''detalles.write(pformat(detalle) + "\n")'''
                elif len(registro[tag]) == 3:
                    if all(key in registro[tag] for key in ['Español', 'Inglés', 'Portugués']):
                        detalles.write('%s %s   L $$aEspañol, portugués, inglés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Español', 'Inglés', 'Francés']):
                        detalles.write('%s %s   L $$aEspañol, inglés, francés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Español', 'Portugués', 'Francés']):
                        detalles.write('%s %s   L $$aEspañol, portugués, francés\n' % (registro['035'], tag))
                    elif all(key in registro[tag] for key in ['Inglés', 'Portugués', 'Francés']):
                        detalles.write('%s %s   L $$aPortugués, inglés, francés\n' % (registro['035'], tag))
                    else:
                        '''detalles.write(pformat(detalle) + "\n")'''
                else:
                    '''detalles.write(pformat(detalle) + "\n")'''
                '''detalles.write(str(registro['035']) + " " + str(tag) + "\n")'''
            if len(registro[tag]) == 1 and tag not in ('100', '110', '120', '520', '650', '653', '654', '856'):
                registro[tag] = registro[tag].pop()
                # if tag not in ['245']:
                #     registro_marc[tag] = registro_marc[tag].pop()
            if type(registro[tag]) in [type({}), type([])]:
                csv += "'%s'" % quotePattern.sub(r"\\'", bslashPattern.sub(r"\\\\", json.dumps(registro[tag], ensure_ascii=True, sort_keys=True)))
            else:
                csv += "'%s'" % quotePattern.sub("\\'", registro[tag])
        else:
            csv += "NULL"
        if tag_offset < len_fields:
            csv += ","
        tag_offset += 1
    '''Transformamos el diccionario en JSON'''
    '''jsonResult = re.sub(r"\\\\\\", "\\\\", json.dumps(registro, ensure_ascii=False, sort_keys=True))'''
    '''Almacenamos la cadena csv en el archivo'''
    fArticle.write(csv + "\n")
    if procesar_siia:
        fArticleSIIA.write(csv + "\n")
        if last_update >= DIFF_DATE:
            fArticleSIIADiff.write(csv + "\n")
        if create_date >= DIFF_DATE:
            fArticleSIIANew.write(csv + "\n")
    csv = None

    '''Agregamos los registros de autores'''
    len_fields = len(fields_author)
    if '100' in registro:
        for counter, autor in enumerate(registro['100']):
            csv = "'%s','%d'," % (registro['035'], counter+1)
            tag_offset = 1
            for field, tag in fields_author:
                if tag in autor:
                    csv += "'%s'" % secuencePattern.sub(r"\1", quotePattern.sub("\\'", autor[tag]))
                else:
                    csv += "NULL"
                if tag_offset < len_fields:
                    csv += ","
                tag_offset += 1
            fAuthor.write(csv + "\n")
            if procesar_siia:
                fAuthorSIIA.write(csv + "\n")
                if last_update >= DIFF_DATE:
                    fAuthorSIIADiff.write(csv + "\n")
                if create_date >= DIFF_DATE:
                    fAuthorSIIANew.write(csv + "\n")

    '''Agregamos los registros de instituciones'''
    len_fields = len(fields_institution)
    if '120' in registro:
        for institucion in registro['120']:
            csv = "'%s'," % registro['035']
            tag_offset = 1
            for field, tag in fields_institution:
                if tag in institucion:
                    csv += "'%s'" % secuencePattern.sub(r"\1", quotePattern.sub("\\'", institucion[tag]))
                else:
                    csv += "NULL"
                if tag_offset < len_fields:
                    csv += ","
                tag_offset += 1
            fInstitution.write(csv + "\n")
            if procesar_siia:
                fInstitutionSIIA.write(csv + "\n")
                if last_update >= DIFF_DATE:
                    fInstitutionSIIADiff.write(csv + "\n")
                if create_date >= DIFF_DATE:
                    fInstitutionSIIANew.write(csv + "\n")

    '''Agregamos el registro del catalogador'''
    len_fields = len(fields_catalogador)
    if 'CAT' in registro:
        for i, catalogador in enumerate(registro['CAT']):
            csv = "'%s','%d'," % (registro['035'], i+1)
            tag_offset = 1
            for field, tag in fields_catalogador:
                if tag not in catalogador:
                    if tag == 'a':
                        catalogador[tag] = 'ALEPH'
                    if tag == 'b':
                        catalogador[tag] = '00'
                if tag == 'h':
                    catalogador[tag] = '%s00' % catalogador[tag]
                if tag in catalogador:
                    csv += "'%s'" % quotePattern.sub("\\'", catalogador[tag])
                else:
                    csv += "NULL"
                if tag_offset < len_fields:
                    csv += ","
                tag_offset += 1
            fCatalogador.write(csv + "\n")
            if procesar_siia:
                fCatalogadorSIIA.write(csv + "\n")
                if last_update >= DIFF_DATE:
                    fCatalogadorSIIADiff.write(csv + "\n")
                if create_date >= DIFF_DATE:
                    fCatalogadorSIIANew.write(csv + "\n")

    # pprint(registro)
    registro_cat = registro_marc['CAT']
    del(registro_marc['CAT'])
    registro_cat2 = registro['CAT']
    del(registro['CAT'])
    #para actualizar se debe hacer por un periodo de tiempo...
    try:
        registro['_id'] = registro['035']
        registro_marc['_id'] = registro_marc['035'][0]['a']
        # articulo_id = articulo.replace_one(
        #                 {'035': registro['035']},
        #                 registro,
        #                 upsert=True
        #             ).upserted_id
        # articulo_id = articulo.insert_one(registro_marc).inserted_id
        # articulo_id2 = articulo2.insert_one(registro).inserted_id
    except Exception as e:
        pprint(registro_marc)
        raise e

    try:
        # cat_history_id = cat_history.replace_one(
        #                     {'articulo_id': articulo_id},
        #                     {'articulo_id': articulo_id, 'CAT': registro_cat},
        #                     upsert=True
        #                 ).upserted_id
        db = ''
        for i, cat in enumerate(registro_cat):
            db = cat['l']
            cat['date'] = datetime(int(cat['c'][:4]), int(cat['c'][4:6]), int(cat['c'][6:]), int(cat['h'][:2]), int(cat['h'][2:4]), int(cat['h'][4:] or 0))
            del(cat['c'])
            del(cat['h'])
            del(cat['l'])
            registro_cat[i] = cat
        # pprint(registro_cat)
        # raw_input("Press Enter to continue...")
        # cat_history_id = cat_history.insert_one({'articulo_id': articulo_id, 'db': db, 'CAT': registro_cat}).inserted_id
        # cat_history_id = cat_history2.insert_one({'articulo_id': articulo_id2, 'db': db, 'CAT': registro_cat2}).inserted_id
    except Exception as e:
        pprint(registro_cat)
        raise e
    
    # registro_json = json.dumps(registro)
    # pprint(registro_json)
    # print('=' * 80)
    # find_result = json.dumps(list(articulo.find({'035': registro['035']}, {'_id': 0}))[0])
    # pprint(find_result)
    # print('=' * 80)
    # print(find_result==registro_json)
    # raw_input("Press Enter to continue...")

    registro = OrderedDict()
    registro_marc = OrderedDict()
    progress += 1
    pbar.update(progress)


def parse_database(database):
    '''Abrimos el archivo con que contiene el resultado de p_print_03 de aleph'''

    global registro, current, tags, len_tags
    '''Inicializamos el valor de la secuencia z para la etiqueta 120'''
    z = 0
    last_tag = ''
    with open(database, 'r') as file:
        '''Leemos cada linea del archivo'''
        for line in file:
            '''Eliminamos el salto de linea al final de la cadena'''
            line = line.strip()
            '''Si es la ultima linea agregamos el registro'''
            if line == "EOF":
                add_record()
                current = ""
                return
            '''Con una expresion regular separamos cada linea en sitema, etiqueta y valor'''
            result = recordPattern.match(line)
            '''Si existe el patron en la linea la procesamos'''
            if result:
                sistema = result.group(1)
                etiqueta = result.group(2)
                valor = result.group(3)
                '''Evaluamos si es un registro diferente para agregar el registro'''
                if current != "" and sistema != current:
                    z = 0
                    last_tag = ''
                    add_record()
                '''Asignamos el valor del registro actual'''
                current = sistema
                '''Inicializamos un diccionario para almacenar los elementos de la etiqueta'''
                subtags = {}
                subtag = {}
                '''Dividimos cada elemento del valor correspondiente a la etiqueta'''
                for element in valor.split('$$')[1:]:
                    '''Con una expresion regular separamos el elmento de su valor'''
                    result_tag = elValPattern.match(element)
                    '''Si existe el patron y tiene un valor agregamos el elemento y su valor al diccionario'''
                    if result and result_tag.group(2) != '':
                        subtag_key = result_tag.group(1)
                        subtag_val = re.sub("[.,]$", "", result_tag.group(2))
                        if etiqueta == '100' and subtag_key in subtag and secuencePattern.match(subtag_val) is not None:
                            # TODO: Add to error log
                            subtag_key = 'z'
                        subtag.update({subtag_key: subtag_val})
                '''Incrementamos el valor de z cuando existe en la etiqueta 120'''
                if etiqueta == '120':
                    z += 1
                    subtag.update({'z': '(%d)' % z})
                '''Ajustamos el valor de la etiqueta 120 cuando esta dentro de la etiqueta 100'''
                if etiqueta == '100' and any(key in subtag for key in ['u', 'v', 'w', 'x']) and any(key in subtag for key in ['a', '6']):
                    '''pprint(current)
                    pprint(subtag)'''
                    z += 1
                    subtag.update({'z': '(%d)' % z})
                    subtags['100'] = dict((k, subtag[k]) for k in ['a', '6', 'z'] if k in subtag)
                    subtags['120'] = dict((k, subtag[k]) for k in ['u', 'v', 'w', 'x', 'z'] if k in subtag)
                    registro['120in100'] = True
                    registro_marc['120in100'] = True
                    '''pprint(subtags)
                    raw_input("Press Enter to continue...")'''
                elif etiqueta == '100' and any(key in subtag for key in ['u', 'v', 'w', 'x']):
                    z += 1
                    subtag.update({'z': '(%d)' % z})
                    subtags['120'] = subtag
                    registro['120in100'] = True
                    registro_marc['120in100'] = True
                elif etiqueta == 'CAT':
                    #if 'a' in subtag and etiqueta not in registro:
                    #   subtags[etiqueta] = subtag
                    subtags[etiqueta] = subtag
                elif len(subtag) > 0:
                    subtags[etiqueta] = subtag

                for etiqueta, subtag in subtags.iteritems():
                    subtag_marc = subtag
                    '''Si el tamanio del diccionario es de 1 almacenamos el valor del elemenro en la etiqueta'''
                    if len(subtag) == 1 and etiqueta not in json_tags:
                        subtag = subtag.itervalues().next()
                    '''Si la etiqueta no esta en el diccionario del registro inicializamos una lista'''
                    if etiqueta not in registro and etiqueta != "520":
                        registro[etiqueta] = []
                        registro_marc[etiqueta] = []
                    elif etiqueta not in registro and etiqueta == "520":
                        registro[etiqueta] = {}
                        registro_marc[etiqueta] = {}
                    '''Agregamos el valor de la etiqueta'''
                    if etiqueta == "520":
                        registro[etiqueta].update(subtag)
                        registro_marc[etiqueta].update(subtag_marc)
                    else:
                        registro[etiqueta].append(subtag)
                        registro_marc[etiqueta].append(subtag_marc)
                    '''Asignamos el valor de la última etiqueta agregada'''
                    last_tag = etiqueta


def set_progress(path, dlib):
    global pbar, progress
    progress = 0
    widgets = ['Parsing %-9s: ' % dlib, Percentage(), ' ', Bar(), ' ', ETA(), ' ', ' ']
    tail = subprocess.Popen(["tail", "-1", path],
                            shell=False,
                            stdout=subprocess.PIPE,
                            stderr=subprocess.PIPE)
    result = tail.stdout.readlines()
    registros = int(result[0])
    if pbar is not None:
        pbar.finish()
    pbar = ProgressBar(widgets=widgets, maxval=registros).start()

print arguments
biblat_make_index()
if arguments.clase:
    path = './database/cla01_valid.txt'
    set_progress(path, "CLASE")
    parse_database(path)
if arguments.periodica:
    path = './database/per01_valid.txt'
    set_progress(path, "PERIODICA")
    parse_database(path)
if arguments.scielo:
    dlib = "SciELO"
    path = './database/scielo_valid.txt'
    set_progress(path, "SciELO")
    parse_database(path)

print sorted(tags)
