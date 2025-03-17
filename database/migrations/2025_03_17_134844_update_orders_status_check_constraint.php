<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateOrdersStatusCheckConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Supprime l'ancienne contrainte
        DB::statement('ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check');

        // Ajoute la nouvelle contrainte avec toutes les valeurs valides
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('en attente', 'en préparation', 'prête', 'payée', 'en_attente'))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supprime la nouvelle contrainte
        DB::statement('ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check');

        // Rétablit l'ancienne contrainte
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('en attente', 'en préparation', 'prête', 'payée'))");
    }
}
