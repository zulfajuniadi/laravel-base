# Version: 51.0.1
# -*- coding: utf-8 -*-
# MySQL Workbench Python script
# <description>
# Written in MySQL Workbench 6.1.7

import grt;
# iterate through columns from schema

def makeName(name):
    name = name.replace('_', ' ', 99)
    name = name.replace(' id', '', 99)
    return name.title()

def makeModelName(name):
    name = name.replace('_', ' ', 99)
    name = name.replace(' id', '', 99)
    name = name.title()
    return name.replace(' ', '', 99)

def getColumnType(name):
    maps = {
        'datetime' : 'dateTime',
        'int' : 'integer',
        'tinyint' : 'boolean',
        'varchar' : 'string',
    }
    if(maps.has_key(name)):
        return maps.get(name)
    return name;

skip_tables = [
    'users', 
    'roles',
    'permission_role',
    'permissions',
    'permission_groups',
    'revisions',
    'role_user',
    'user_blacklists',
    'auth_logs',
    'migrations',
    'password_resets']

str = ''
schema = grt.root.wb.doc.physicalModels[0].catalog.schemata[0]
for table in schema.tables:
    if ((table.name not in skip_tables) == True):
        str = str + '[' + table.name + '] ' + "\n" + 'php artisan make:module ' + table.name + ' "'
        columns = []
        fkeys = []
        for column in table.columns:
            if column.name not in ('id', 'created_at', 'updated_at', 'slug'):
                columns.append("%s:%s:%s" % (column.name, makeName(column.name), getColumnType((column.simpleType or column.userType).name.lower())))
        for fkey in table.foreignKeys:
            fkeys.append("belongsTo:%s:%s:%s" % (makeModelName(fkey.columns[0].name), fkey.referencedTable.name, fkey.columns[0].name))
        str += '|'.join(columns) + '" '
        if(len(fkeys) > 0):
            str += '"' + ('|'.join(fkeys)) + '" '
        str += "\n\n" 
print str
