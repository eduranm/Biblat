#!/usr/bin/python
# -*- coding: utf-8 -*-
import re
import json
from pprint import pprint, pformat

'''Inicializando variables para almacenar las etiquetas del registro y el registro actual'''
registro = {}
current = ""
tags = ['008', '022', '024', '035', '036', '039', '041', '100', '110', '120', '222', '245', '260', '300', '504', '520', '546', '590', '650', '653', '654', '698', '856']
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
	('url', '865')
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
lenTags = len(tags)
'''Abrimos archivos para guradar los resultados'''
detalles = open('../claperDetalles.txt', 'w')
fClaPerJSON = open('../claperJSON.txt', 'w')
fArticle = open('../articuloCLAPER.txt', 'w')
fAuthor = open('../autorCLAPER.txt', 'w')
fInstitution = open('../institucionCLAPER.txt', 'w')
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
	global registro
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
				csv += "'"+ re.sub(r"'", r"\\'", re.sub(r"\\", r"\\\\", json.dumps(registro[tag], ensure_ascii=True, sort_keys=True))) + "'"
			else:
				csv += "'"+ re.sub(r"'", "\\'", registro[tag]) + "'"
		else:
			csv += "NULL"
		if tagOffset < lenFields:
			csv += ","
		tagOffset += 1
	'''Transformamos el diccionario en JSON'''
	'''jsonResult = re.sub(r"\\\\\\", "\\\\", json.dumps(registro, ensure_ascii=False, sort_keys=True))'''
	'''Almacenamos la cadena JSON en el archivo'''
	if registro['035'] == "CLA01000006501A":
		pprint(registro)
		raw_input("Press Enter to continue...")
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
					csv += "'"+ re.sub(r"^\(([0-9]+?)\)$", r"\1", re.sub(r"'", "\\'", autor[tag])) + "'"
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
					csv += "'"+ re.sub(r"^\(([0-9]+?)\)$", r"\1", re.sub(r"'", "\\'", institucion[tag])) + "'"
				else:
					csv += "NULL"
				if tagOffset < lenFields:
					csv += ","
				tagOffset += 1
			fInstitution.write(csv + "\n")

	registro = {}

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
			'''Con una expresion regular separamos cada linea en sitema, etiqueta y valor'''
			result = re.match(r'(^[0-9]+?)\s([0-9]+?)\s.+?L\s(.+?$)', line)
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
					resultTag = re.match(r'(.)(.*?$)', element)
					'''Si existe el patron y tiene un valor agregamos el elemento y su valor al diccionario'''
					if result and resultTag.group(2) != '':
						subtag.update({resultTag.group(1):re.sub(",$","",resultTag.group(2))})
				'''Incrementamos el valor de z cuando existe en la etiqueta 120'''
				if etiqueta == '120' and 'z' in subtag:
					z += 1
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

'''Funcion para agregar los registros de clase y periodica'''
def add_claper():
	'''Escribimos encabezados de los archivos'''
	'''tagOffset=1
	for tag in tags:
		fClaPerJSON.write("'" + tag + "'")
		if tagOffset < lenTags:
			fClaPerJSON.write(",")
		else:
			fClaPerJSON.write("\n")
		tagOffset += 1

	fieldOffset=1
	lenFields = len(fieldsArticle)
	for field in fieldsArticle:
		fArticle.write("'" + field + "'")
		if fieldOffset < lenFields:
			fArticle.write(",")
		else:
			fArticle.write("\n")
		fieldOffset += 1'''
	parse_database('../clase_valid.txt')
	parse_database('../periodica_valid.txt')

add_claper()

print sorted(tags)
