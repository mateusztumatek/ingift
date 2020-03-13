<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('url')->unique();
            $table->text('short_desc')->nullable();
            $table->string('images')->nullable();
            $table->string('main_image');
            $table->string('page_title');
            $table->string('page_description')->nullable();
            $table->float('price');
            $table->float('price_sellout')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_new');
            $table->integer('stock')->default(1);
            $table->string('sku')->nullable();
            $table->string('sku_parrent')->nullable();
            $table->string('country')->default('pl');
            $table->float('weight')->nullable();
            $table->integer('in_package')->nullable();
            $table->integer('orders_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('external_id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
