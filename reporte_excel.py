#!/usr/bin/python
# -*- coding: utf-8 -*-
import xlsxwriter
import psycopg2.extras
from datetime import date, timedelta

# Constantes
YEAR = 2018


# month_delta
def monthdelta(date, delta):
    m, y = (date.month+delta) % 12, date.year + (date.month+(delta-1)) // 12
    if not m: m = 12
    d = min(
        date.day,
        [31, 29 if y % 4 == 0 and not y % 400 == 0 else 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m-1])
    return date.replace(day=d, month=m, year=y) - timedelta(days=1)


# Conexión PostgreSQL
def result_iter(cursor, arraysize=1000):
    # An iterator that uses fetchmany to keep memory usage down
    while True:
        results = cursor.fetchmany(arraysize)
        if not results:
            break
        for result in results:
            yield result


psycopg2.extensions.register_type(psycopg2.extensions.UNICODE)
psycopg2.extensions.register_type(psycopg2.extensions.UNICODEARRAY)
conn = psycopg2.connect("dbname=claper user=arendon host=localhost")
cur = conn.cursor(cursor_factory=psycopg2.extras.DictCursor)


# Libros
libros = {
    'ingresados': xlsxwriter.Workbook('Reporte registros ingresados por catalogador 2018.xlsx'),
    'editados': xlsxwriter.Workbook('Reporte registros ingresados-editados por catalogador 2018.xlsx')
}


def setup_pages(element):
    workbook = libros[element]
    # Páginas
    enero = workbook.add_worksheet('Enero')
    febrero = workbook.add_worksheet('Febrero')
    marzo = workbook.add_worksheet('Marzo')
    trimestre1 = workbook.add_worksheet('1er Trimestre')
    abril = workbook.add_worksheet('Abril')
    mayo = workbook.add_worksheet('Mayo')
    junio = workbook.add_worksheet('Junio')
    trimestre2 = workbook.add_worksheet('2do Trimestre')
    semestre1 = workbook.add_worksheet('1er Semestre')
    julio = workbook.add_worksheet('Julio')
    agosto = workbook.add_worksheet('Agosto')
    septiembre = workbook.add_worksheet('Septiembre')
    trimestre3 = workbook.add_worksheet('3er Trimestre')
    octubre = workbook.add_worksheet('Octubre')
    noviembre = workbook.add_worksheet('Noviembre')
    diciembre = workbook.add_worksheet('Diciembre')
    trimestre4 = workbook.add_worksheet('4to Trimestre')
    semestre2 = workbook.add_worksheet('2do Semestre')
    anual = workbook.add_worksheet('Anual')

    paginas = [
        enero,
        febrero,
        marzo,
        abril,
        mayo,
        junio,
        julio,
        agosto,
        septiembre,
        octubre,
        noviembre,
        diciembre,
        trimestre1,
        trimestre2,
        trimestre3,
        trimestre4,
        semestre1,
        semestre2,
        anual
    ]

    # Estilos
    merge_format = workbook.add_format({'bold': True, 'align': 'center'})

    for pagina in paginas:
        pagina.merge_range('A1:B1', u'CLASE + PERIÓDICA', merge_format)
        pagina.write('A2', 'Catalogador', merge_format)
        pagina.write('B2', 'Registros', merge_format)
        pagina.merge_range('E1:F1', u'CLASE', merge_format)
        pagina.write('E2', 'Catalogador', merge_format)
        pagina.write('F2', 'Registros', merge_format)
        pagina.merge_range('I1:J1', u'PERIÓDICA', merge_format)
        pagina.write('I2', 'Catalogador', merge_format)
        pagina.write('J2', 'Registros', merge_format)

    for trimestre in paginas[12:16]:
        trimestre.set_tab_color('blue')

    for semestre in paginas[16:18]:
        semestre.set_tab_color('orange')

    anual.set_tab_color('green')

    return paginas


def generar_reporte(element, paginas_range, periodo):
    bold = libros[element].add_format({'bold': True})
    month = 1

    registrados = "id=1 AND "
    if element == 'editados':
        registrados = ""

    for pagina_mes in paginas_range:
        fecha_inicial = date(YEAR, month, 1)
        fecha_final = monthdelta(fecha_inicial, periodo)
        fecha_inicial = fecha_inicial.strftime('%Y-%m-%d')
        fecha_final = fecha_final.strftime('%Y-%m-%d')
        print(fecha_inicial, fecha_final)
        # CLASE + PERIÓDICA
        cur.execute("""
        SELECT
        --*
        nombre, count(*) AS registros
        FROM catalogador WHERE {registrados}fecha BETWEEN '{start}' AND '{end}'
        GROUP BY nombre
        ORDER BY nombre;""".format(registrados=registrados, start=fecha_inicial, end=fecha_final))

        page_row = 3
        for row in result_iter(cur):
            pagina_mes.write('A%d' % page_row, row['nombre'])
            pagina_mes.write('B%d' % page_row, row['registros'])
            page_row += 1

        page_row_sum = page_row + 3

        # CLASE
        cur.execute("""
        SELECT
        --*
        nombre, count(*) AS registros
        FROM catalogador WHERE {registrados}fecha BETWEEN '{start}' AND '{end}'
        AND SUBSTRING(sistema, 1, 5)='CLA01'
        GROUP BY nombre
        ORDER BY nombre;""".format(registrados=registrados, start=fecha_inicial, end=fecha_final))

        page_row = 3
        for row in result_iter(cur):
            pagina_mes.write('E%d' % page_row, row['nombre'])
            pagina_mes.write('F%d' % page_row, row['registros'])
            page_row += 1

        # PERIÓDICA
        cur.execute("""
        SELECT
        --*
        nombre, count(*) AS registros
        FROM catalogador WHERE {registrados}fecha BETWEEN '{start}' AND '{end}'
        AND SUBSTRING(sistema, 1, 5)='PER01'
        GROUP BY nombre
        ORDER BY nombre;""".format(registrados=registrados, start=fecha_inicial, end=fecha_final))

        page_row = 3
        for row in result_iter(cur):
            pagina_mes.write('I%d' % page_row, row['nombre'])
            pagina_mes.write('J%d' % page_row, row['registros'])
            page_row += 1

        # SUM
        print(page_row_sum)
        if page_row_sum > 6:
            pagina_mes.write('B%d' % page_row_sum, '=SUM(B3:B%d)' % (page_row_sum - 3), bold)
            pagina_mes.write('F%d' % page_row_sum, '=SUM(F3:F%d)' % (page_row_sum - 3), bold)
            pagina_mes.write('J%d' % page_row_sum, '=SUM(J3:J%d)' % (page_row_sum - 3), bold)

        month += periodo


for libro in libros:
    paginas = setup_pages(libro)

    generar_reporte(libro, paginas[:12], 1)
    generar_reporte(libro, paginas[12:16], 3)
    generar_reporte(libro, paginas[16:18], 6)
    generar_reporte(libro, paginas[18:], 12)

    libros[libro].close()

