<?PHP

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_statuses', function (Blueprint $table) {
            $table->integer('sort')->default(0); // Adjust 'after' as needed
        });
    }

    public function down(): void
    {
        Schema::table('project_statuses', function (Blueprint $table) {

            $table->dropColumn('sort');
        });
    }
};
