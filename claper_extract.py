#!/usr/bin/python
# -*- coding: utf-8 -*-
import re
import json
import argparse
from pprint import pprint, pformat
from progressbar import *
import subprocess

parser = argparse.ArgumentParser()
parser.add_argument('-range', action='store_true', default=False, dest='scielo_range', help='Print scielo range list')
parser.add_argument('-noclase', action='store_false', default=True, dest='clase', help='No parse clase db')
parser.add_argument('-noperiodica', action='store_false', default=True, dest='periodica', help='No parse periodica db')
parser.add_argument('-scielo', action='store_true', default=False, dest='scielo', help='Parse sciel rage in periodica')
arguments = parser.parse_args()

'''Inicializando variables para almacenar las etiquetas del registro y el registro actual'''
pbar = None
progress = 0
registro = {}
current = ""
tags = ['008', '022', '024', '035', '036', '039', '041', '100', '110', '120', '222', '245', '260', '300', '504', '520', '546', '590', '650', '653', '654', '698', '856', 'CAT']
jsonTags = ('100', '110', '120', '300', '520', '590')
fieldsArticle = [
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
fieldsAuthor = [
	('nombre', 'a'),
	('email', '6'),
	('institucionId', 'z')
]
fieldsInstitution = [
	('id', 'z'),
	('institucion', 'u'),
	('dependencia', 'v'),
	('ciudad', 'w'),
	('pais', 'x')
]
fieldsCatalogador = [
	('nombre', 'a'),
	('nivel', 'b'),
	('fechaEdicion', 'c'),
	('horaEdicion', 'h')
]
lenTags = len(tags)

'''Patrones compilados'''
recordPattern = re.compile(r'(^[0-9]+?)\s([0-9]+?|CAT)\s.+?L\s(.+?$)')
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
'''Funcion para comparar la afiliación del autor esta duplicada'''
def duplicate_aff(tag, compare):
	del compare['z']
	for afiliation in tag:
		if 'z' in afiliation:
			del afiliation['z']
		print cmp(afiliation, compare)
		if cmp(afiliation, compare) == 0:
			return True
	return False
'''Funcion para agregar el registro'''
def add_record():
	global registro, pbar, progress

	csv = ""
	'''Ajustamos los autores con su institución'''
	if '100' in registro and '120' in registro and '120in100' in registro and len(registro['100']) > 1: 
		if(len(registro['100']) == len(registro ['120']) or len(registro['100']) < len(registro ['120'])) :
			for i in range(0, len(registro['100'])):
				registro['100'][i].update({'z':'(%d)'%(i+1)})
		elif len(registro['100']) > len(registro ['120']):
			registro['100'][0].update({'z':'(1)'})
			for i in range(1, len(registro['100'])):
				if 'z' in registro['100'][i]:
					del registro['100'][i]['z']
		del registro['120in100']

	'''Agregamos los registros de documentos'''
	tagOffset=1
	lenFields = len(fieldsArticle)
	for key, tag in fieldsArticle:
		if tag in registro:
			'''Si el tamaño de la etiqueta es 1 asignamos el primer elemento de la lista a la etiqueta'''
			if len(registro[tag]) > 1 and tag not in ('100', '110', '120', '520', '650', '653', '654', '856'):
				detalle = {'035':registro['035'], tag:registro[tag]}
				if registro[tag][0] == registro[tag][1]:
					for line in registro[tag]:
						detalles.write('%s %s   L $$a%s\n'%(registro['035'], tag, line))
						'''detalles.write(pformat(detalle) + "\n")'''
				'''detalles.write(str(registro['035']) + " " + str(tag) + "\n")'''
			if len(registro[tag]) == 1 and tag not in ('100', '110', '120', '520', '650', '653', '654', '856'):
				registro[tag] = registro[tag].pop()
			if type(registro[tag]) in [type({}), type([])]:
				csv += "'"+ quotePattern.sub(r"\\'", bslashPattern.sub(r"\\\\", json.dumps(registro[tag], ensure_ascii=True, sort_keys=True))) + "'"
			else:
				csv += "'"+ quotePattern.sub("\\'", registro[tag]) + "'"
		else:
			csv += "NULL"
		if tagOffset < lenFields:
			csv += ","
		tagOffset += 1
	'''Transformamos el diccionario en JSON'''
	'''jsonResult = re.sub(r"\\\\\\", "\\\\", json.dumps(registro, ensure_ascii=False, sort_keys=True))'''
	'''Almacenamos la cadena csv en el archivo'''
	fArticle.write(csv + "\n")
	csv = None

	'''Agregamos los registros de autores'''
	lenFields = len(fieldsAuthor)
	if '100' in registro:
		for counter,autor  in enumerate(registro['100']):
			csv =  "'%s',"%registro['035']
			csv += "'%d',"%(counter+1)
			tagOffset=1
			for field, tag in fieldsAuthor:
				if tag in autor:
					csv += "'"+ secuencePattern.sub(r"\1", quotePattern.sub("\\'", autor[tag])) + "'"
				else:
					csv += "NULL"
				if tagOffset < lenFields:
					csv += ","
				tagOffset += 1
			fAuthor.write(csv + "\n")

	'''Agregamos los registros de instituciones'''
	lenFields = len(fieldsInstitution)
	if '120' in registro:
		for institucion  in registro['120']:
			csv = "'%s',"%registro['035']
			tagOffset=1
			for field, tag in fieldsInstitution:
				if tag in institucion:
					csv += "'"+ secuencePattern.sub(r"\1", quotePattern.sub("\\'", institucion[tag])) + "'"
				else:
					csv += "NULL"
				if tagOffset < lenFields:
					csv += ","
				tagOffset += 1
			fInstitution.write(csv + "\n")

	'''Agregamos el registro del catalogador'''
	lenFields = len(fieldsCatalogador)
	if 'CAT' in registro:
		for catalogador in registro['CAT']:
			csv = "'%s',"%registro['035']
			tagOffset=1
			for field, tag in fieldsCatalogador:
				if tag in catalogador:
					csv += "'"+ quotePattern.sub("\\'", catalogador[tag]) + "'"
				else:
					csv += "NULL"
				if tagOffset < lenFields:
					csv += ","
				tagOffset += 1
			fCatalogador.write(csv + "\n")

	registro = {}
	progress += 1
	pbar.update(progress)

'''Abrimos el archivo con que contiene el resultado de p_print_03 de aleph'''
def parse_database(database):
	global registro, current, tags, lenTags
	'''Inicializamos el valor de la secuencia z para la etiqueta 120'''
	z = 0
	lastTag = ''
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
					lastTag = ''
					add_record()
				'''Asignamos el valor del registro actual'''
				current = sistema
				'''Inicializamos un diccionario para almacenar los elementos de la etiqueta'''
				subtags = {};
				subtag = {}
				'''Dividimos cada elemento del valor correspondiente a la etiqueta'''
				for element in valor.split('$$')[1:]:
					'''Con una expresion regular separamos el elmento de su valor'''
					resultTag = elValPattern.match(element)
					'''Si existe el patron y tiene un valor agregamos el elemento y su valor al diccionario'''
					if result and resultTag.group(2) != '':
						subtag.update({resultTag.group(1):re.sub("[.,]$","",resultTag.group(2))})
				'''Incrementamos el valor de z cuando existe en la etiqueta 120'''
				if etiqueta == '120':
					z += 1
					subtag.update({'z':'(%d)'%z})
				'''Ajustamos el valor de la etiqueta 120 cuando esta dentro de la etiqueta 100'''
				if etiqueta == '100' and any(key in subtag for key in ['u', 'v', 'w', 'x']) and any(key in subtag for key in ['a', '6']):
					'''pprint(current)
					pprint(subtag)'''
					z += 1
					subtag.update({'z':'(%d)'%z})
					subtags['100'] = dict((k, subtag[k]) for k in ['a', '6', 'z'] if k in subtag)
					subtags['120'] = dict((k, subtag[k]) for k in ['u', 'v', 'w', 'x', 'z'] if k in subtag)
					registro['120in100'] = True
					'''pprint(subtags)
					raw_input("Press Enter to continue...")'''
				elif etiqueta == '100' and any(key in subtag for key in ['u', 'v', 'w', 'x']):
					z += 1
					subtag.update({'z':'(%d)'%z})
					subtags['120'] = subtag
					registro['120in100'] = True
					if lastTag == '100':
						registro['100'][-1].update({'z':'(%d)'%z})
				elif etiqueta == 'CAT':
					if 'a' in subtag and etiqueta not in registro:
						subtags[etiqueta] = subtag
				elif len(subtag) > 0:
					subtags[etiqueta] = subtag

				for etiqueta, subtag in subtags.iteritems():
					'''Si el tamanio del diccionario es de 1 almacenamos el valor del elemenro en la etiqueta'''
					if len(subtag) == 1 and etiqueta not in jsonTags:
						subtag = subtag.itervalues().next()
					'''Si la etiqueta no esta en el diccionario del registro inicializamos una lista'''
					if etiqueta not in registro and etiqueta != "520":
						registro[etiqueta] = []
					elif etiqueta not in registro and etiqueta == "520":
						registro[etiqueta] = {}
					'''Agregamos el valor de la etiqueta'''
					if etiqueta == "520":
						registro[etiqueta].update(subtag)
					else:
						registro[etiqueta].append(subtag)
					'''Asignamos el valor de la última etiqueta agregada'''
					lastTag = etiqueta

def set_progress(path, dlib):
	global pbar, progress
	progress = 0
	widgets = ['Parsing %s: ' % dlib, Percentage(), ' ', Bar(), ' ', ETA(), ' ', ' ']
	tail = subprocess.Popen(["tail", "-1", path],
		shell=False,
		stdout=subprocess.PIPE,
		stderr=subprocess.PIPE)
	result = tail.stdout.readlines()
	registros = int(result[0])
	if pbar != None:
		pbar.finish()
	pbar = ProgressBar(widgets=widgets, maxval=registros).start()

print arguments
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
	set_progress(path)
	parse_database(path)

print sorted(tags)
