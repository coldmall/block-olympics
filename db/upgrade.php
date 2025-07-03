<?php
/**
 * Upgrade steps for block_olympics
 */
function xmldb_block_olympics_upgrade(int $oldversion): bool {
    global $DB;

    $dbman = $DB->get_manager();

    // Переход с версий < 2025070600: создаём таблицу.
    if ($oldversion < 2025070600) {

        // Описание таблицы
        $table = new xmldb_table('block_olympics');

        $table->add_field('id',         XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name',       XMLDB_TYPE_CHAR,    '255', null,          XMLDB_NOTNULL, null, null);
        $table->add_field('description',XMLDB_TYPE_TEXT,    null,  null,          null,          null, null);
        $table->add_field('startdate',  XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
        $table->add_field('enddate',    XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);

        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Создаём таблицу, если её нет
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Фиксируем точку обновления
        upgrade_block_savepoint(true, 2025070600, 'olympics');
    }

    return true;
}
