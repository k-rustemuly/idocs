<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs', function (Blueprint $table) {
            $table->id();
            $table->string("group");
            $table->string("content_name")->comment("Название печатной формы документа")->nullable();
            $table->string("extension")->comment("Расширение печатной формы документа (.pdf, .docx и т.д.)")->nullable();
            $table->string("doc_id")->comment("Уникальный ID документа")->nullable()->unique("doc_id");
            $table->string("name")->comment("Название документа")->nullable();
            $table->string("number")->comment("Номер документа")->nullable();
            $table->string("status")->comment("Статус")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docs');
    }
};
