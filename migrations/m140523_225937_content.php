<?php

class m140523_225937_content extends DbMigration
{
	public function up()
	{
        $this->createTable('{{content}}',[
            'id'=>'pk',
            'name'=>'VARCHAR(255)',
            'alias'=>'VARCHAR(255)',
            'enabled'=>'TINYINT NOT NULL DEFAULT 0',
            'content'=>'TEXT',
            'type'=>'TINYINT NOT NULL',
            'parent_id'=>'INT NULL DEFAULT NULL',
            'image_id'=>'INT',
            'short_content'=>'TEXT',
            'sort'=>'INT NULL DEFAULT NULL',
            'publish_date'=>'DATETIME NULL DEFAULT NULL',
            'create_time'=>'DATETIME',
            'update_time'=>'DATETIME',
        ]);
		
		 if (!db()->getSchema()->getTable('{{content_lang}}')) {
            $this->createTable('{{content_lang}}', [
                'l_id' => 'pk',
                'entity_id' => 'INT NOT NULL',
                'lang_id' => 'VARCHAR(6) NOT NULL',
                'l_name' => 'VARCHAR(255)',
                'l_content' => 'TEXT',
                'l_short_content' => 'TEXT',
            ]);
            $this->createIndex('c_ei', '{{content_lang}}', 'entity_id');
            $this->createIndex('c_li', '{{content_lang}}', 'lang_id');

            $this->addForeignKey('c_ibfk_1', '{{content_lang}}', 'entity_id', '{{content}}', 'id', 'CASCADE', 'CASCADE');

        }
	}

	public function down()
	{
		$this->dropTable('{{content_lang}}');
	
        $this->dropTable('{{content}}');
	}

}