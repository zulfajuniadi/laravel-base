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

skip_tables = ['users', 'roles', 'permission_role', 'permissions', 'assigned_roles', 'uploads', 'password_reminders', 'reports', 'report_fields', 'report_columns', 'report_groupings' , 'report_eagers']
str = ''

schema = grt.root.wb.doc.physicalModels[0].catalog.schemata[0]
for table in schema.tables:
    if ((table.name not in skip_tables) == True):
        str = str + '[' + table.name + '] ' + "\n" + 'artisan generate:datatable -n --fields="'
        columns = []
        for column in table.columns:
            if column.name not in ('id', 'created_at', 'updated_at'):
                columns.append("%s:%s:%s" % (makeName(column.name), column.name, (column.simpleType or column.userType).name.lower()))
        str += ', '.join(columns) + '" ' + table.name + " true\n\n"
print str
