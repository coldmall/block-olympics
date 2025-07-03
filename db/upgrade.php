<?php
function xmldb_block_olympics_upgrade(int $oldversion): bool {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2025070800) {

        $table = new xmldb_table('block_olympics_enrol');
        $table->add_field('id',           XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('olympiadid',   XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('userid',       XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL);

        $table->add_key  ('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key  ('uniq',    XMLDB_KEY_UNIQUE,  ['olympiadid', 'userid']);

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        upgrade_block_savepoint(true, 2025070800, 'olympics');
    }
    return true;
}
