<?php
 
//
// NOTE Migration Created: 2017-01-12 16:00:33
// --------------------------------------------------
 
class CreateRelleDatabase {
//
// NOTE - Make changes to the database.
// --------------------------------------------------
 
public function up()
{

//
// NOTE -- docs
// --------------------------------------------------
 
Schema::create('docs', function($table) {
 $table->increments('id');
 $table->string('type', 100);
 $table->string('title', 3000);
 $table->string('size', 500);
 $table->string('format', 50);
 $table->text('lang');
 $table->string('tags', 3000);
 $table->unsignedInteger('subject_id');
 $table->string('url', 500);
 $table->timestamp('created_at')->default("CURRENT_TIMESTAMP");
 $table->unsignedInteger('updated_at');
 });


//
// NOTE -- docs_labs
// --------------------------------------------------
 
Schema::create('docs_labs', function($table) {
 $table->increments('id');
 $table->unsignedInteger('lab_id');
 $table->unsignedInteger('doc_id');
 });


//
// NOTE -- instances
// --------------------------------------------------
 
Schema::create('instances', function($table) {
 $table->increments('id');
 $table->increments('lab_id');
 $table->string('address', 50);
 $table->unsignedInteger('duration');
 $table->boolean('queue');
 $table->boolean('maintenance');
 $table->string('client', 255);
 $table->string('js', 50);
 $table->string('pt', 50);
 $table->string('defaulthtml', 255);
 $table->string('en', 255);
 $table->string('es', 255);
 $table->string('css', 50);
 $table->string('secret', 255);
 });


//
// NOTE -- labs
// --------------------------------------------------
 
Schema::create('labs', function($table) {
 $table->increments('id');
 $table->string('name_pt', 255);
 $table->string('name_en', 255);
 $table->string('name_es', 255);
 $table->string('description_pt', 500);
 $table->string('description_en', 500);
 $table->string('description_es', 500);
 $table->string('tags', 250);
 $table->string('duration', 255);
 $table->unsignedInteger('resources');
 $table->string('target', 255);
 $table->string('subject', 255);
 $table->string('difficulty', 255);
 $table->string('interaction', 255);
 $table->string('thumbnail', 255);
 $table->boolean('queue')->default("1");
 $table->string('tutorial_pt', 3000);
 $table->string('tutorial_en', 3000);
 $table->string('tutorial_es', 3000);
 $table->string('video', 3000);
 $table->unsignedInteger('maintenance');
 });


//
// NOTE -- password_resets
// --------------------------------------------------
 
Schema::create('password_resets', function($table) {
 $table->string('email', 255);
 $table->string('token', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- sessions
// --------------------------------------------------
 
Schema::create('sessions', function($table) {
 $table->increments('id', 255);
 $table->text('payload');
 $table->unsignedInteger('last_activity');
 });


//
// NOTE -- subjects
// --------------------------------------------------
 
Schema::create('subjects', function($table) {
 $table->increments('id');
 $table->string('name', 5000);
 });


//
// NOTE -- subjects_labs
// --------------------------------------------------
 
Schema::create('subjects_labs', function($table) {
 $table->increments('id');
 $table->unsignedInteger('subject_id');
 $table->unsignedInteger('lab_id');
 });


//
// NOTE -- users
// --------------------------------------------------
 
Schema::create('users', function($table) {
 $table->increments('id')->unsigned();
 $table->string('firstname', 255);
 $table->string('lastname', 255);
 $table->string('username', 255);
 $table->string('email', 255);
 $table->string('password', 255);
 $table->string('organization', 255);
 $table->string('country', 255);
 $table->string('type', 255)->default("user");
 $table->string('avatar', 255);
 $table->string('remember_token', 250);
 });


//
// NOTE -- docs_labs_foreign
// --------------------------------------------------
 
Schema::table('docs_labs', function($table) {
 $table->foreign('lab_id')->references('id')->on('labs');
 $table->foreign('doc_id')->references('id')->on('docs');
 });


//
// NOTE -- instances_foreign
// --------------------------------------------------
 
Schema::table('instances', function($table) {
 $table->foreign('lab_id')->references('id')->on('labs');
 });


//
// NOTE -- subjects_labs_foreign
// --------------------------------------------------
 
Schema::table('subjects_labs', function($table) {
 $table->foreign('subject_id')->references('id')->on('subjects');
 $table->foreign('lab_id')->references('id')->on('labs');
 });



}
 
//
// NOTE - Revert the changes to the database.
// --------------------------------------------------
 
public function down()
{

Schema::drop('docs');
Schema::drop('docs_labs');
Schema::drop('instances');
Schema::drop('labs');
Schema::drop('password_resets');
Schema::drop('sessions');
Schema::drop('subjects');
Schema::drop('subjects_labs');
Schema::drop('users');

}
}