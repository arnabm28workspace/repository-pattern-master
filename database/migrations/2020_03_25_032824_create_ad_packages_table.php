<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ad_id');
            $table->integer('package_id');
            $table->float('price', 8, 2)->default(0.00);
            $table->integer('duration')->default(0);
            $table->date('expiry_date');
            $table->string('package_type');
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
        Schema::dropIfExists('ad_packages');
    }
}
