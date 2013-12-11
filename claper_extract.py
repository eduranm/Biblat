#!/usr/bin/python
# -*- coding: utf-8 -*-
import re
import json
from collections import OrderedDict

'''Inicializando variables para almacenar las etiquetas del registro y el registro actual'''
registro = {}
current = ""
tags = ['008', '022', '024', '035', '036', '039', '041', '100', '110', '120', '222', '245', '260', '300', '504', '520', '546', '590', '650', '653', '654', '698', '856']
lenTags = len(tags)
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
	if '100' in registro and '120' in registro and len(registro['100']) == len(registro ['120']):
		if 'z' not in registro['100'][0]:
			registro['120'][0].update({'z': '(1)'})
			registro['100'][0].update({'z': '(1)'})
		link=2
		for i in range(1, len(registro['120'])):
			registro['120'][i].update({'z': '(' + str(link) + ')'})
			registro['100'][i].update({'z': '(' + str(link) + ')'})
			'''if link > 1 and len(registro['120']) > 1 and duplicate_aff(registro['120'], registro['100'][i]):
				print json.dumps(registro, ensure_ascii=False, sort_keys=True)
				exit(0)'''
			link += 1
		
	'''Leemos cada etiqueta del registro'''
	tagOffset=1
	for tag in tags:
		if tag in registro:
			'''Si el tamanio de la etiqueta es 1 asignamos el primer elemento de la lista a la etiqueta'''
			if len(registro[tag]) == 1 and tag not in ('100', '110', '120', '520', '650', '653', '654'):
				registro[tag] = registro[tag].pop()
			if type(registro[tag]) in [type({}), type([])]:
				csv += "'"+ re.sub(r"'", "\\'", json.dumps(registro[tag], ensure_ascii=False, sort_keys=True)) + "'"
			else:
				csv += "'"+ re.sub(r"'", "\\'", registro[tag]) + "'"
		else:
			csv += "NULL"
		if tagOffset < lenTags:
			csv += ","
		tagOffset += 1
	'''Transormamos el diccionario en JSON'''
	jsonResult = re.sub(r"\\\\\\", "\\\\", json.dumps(registro, ensure_ascii=False, sort_keys=True))
	'''Almacenamos la cadena JSON en el archivo'''
	with open('../periodicaJSON.txt', 'a') as fileJSON:
		fileJSON.write(csv + "\n")
	registro = {}

'''Abrimis archivo para almacenar el resultado del proceso'''
with open('../periodicaJSON.txt', 'w') as file:
	tagOffset=1
	for tag in tags:
		file.write("'" + tag + "'")
		if tagOffset < lenTags:
			file.write(",")
		else:
			file.write("\n")
		tagOffset += 1


'''Abrimos el archivo con que contiene el resultado de p_print_03 de aleph'''
with open('../clase_101213_valid.txt', 'r') as file:
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
				add_record()
			'''Asignamos el valor del registro actual'''
			current = sistema
			'''Inicializamos un diccionario para almacenar los elementos de la etiqueta'''
			subtags = {}
			'''Dividimos cada elemento del valor correspondiente a la etiqueta'''
			for element in valor.split('$$')[1:]:
				'''Con una expresion regular separamos el elmento de su valor'''
				resultTag = re.match(r'(.)(.*?$)', element)
				'''Si existe el patron agregamos el elemento y su valor al diccionario'''
				if result:
					subtags.update({resultTag.group(1):resultTag.group(2)})
					if etiqueta == "100" and resultTag.group(1) in ['u', 'v', 'w', 'x']:
						etiqueta = "120"
			'''Si el tamanio del diccionario es de 1 almacenamos el valor del elemenro en la etiqueta'''
			if len(subtags) == 1 and etiqueta not in ('100', '110', '120', '520'):
				subtags = subtags.itervalues().next()
			'''Si la etiqueta no esta en el diccionario del registro inicializamos una lista'''
			if etiqueta not in registro and etiqueta != "520":
				registro[etiqueta] = []
			elif etiqueta not in registro and etiqueta == "520":
				registro[etiqueta] = {}
			'''Agregamos el valor de la etiqueta si no existe dentro de la lista'''
			if etiqueta == "520":
				registro[etiqueta].update(subtags)
			elif etiqueta in ('100', '110', '120'):
				registro[etiqueta].append(subtags)
			elif subtags not in registro[etiqueta]:
				registro[etiqueta].append(subtags)

print sorted(tags)
