# -*- coding: utf-8 -*-
# MySQL Workbench Python script
# <description>
# Written in MySQL Workbench 6.1.7

import grt;
#import mforms
# iterate through columns from schema

def makeName(name):
    name = name.replace('_', ' ', 99)
    name = name.replace(' id', '', 99)
    return name.title()


schema = grt.root.wb.doc.physicalModels[0].catalog.schemata[0]
str = "git clone https://github.com/zulfajuniadi/laravel-base.git . && rm -rf .git && composer update && artisan du && artisan app:reset\n"
str += 'artisan app:reset' + "\n";
for table in schema.tables:
    str += 'artisan generate:datatable -n --fields="'
    columns = []
    for column in table.columns:
        if column.name not in ('id', 'created_at', 'updated_at'):
            columns.append("%s:%s:%s" % (makeName(column.name), column.name, column.simpleType.name.lower()))
    str += ', '.join(columns) + '" ' + table.name + " true\n"

print str
