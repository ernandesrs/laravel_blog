<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRegister extends Model
{
    use HasFactory;

    public const weekDays = [
        "mon" => 0,
        "tue" => 0,
        "wed" => 0,
        "thu" => 0,
        "fri" => 0,
        "sat" => 0,
        "sun" => 0
    ];

    protected $fillable = ["name", "params"];

    public function monitored()
    {
        $monitored = $this->belongsTo(Page::class, "id", "access_register_id");
        if ($monitored->count())
            return $monitored->first();

        $monitored = $this->belongsTo(Article::class, "id", "access_register_id");
        if ($monitored->count())
            return $monitored->first();
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->access++;
        $this->weekly_access++;
        $this->daily();
        $this->save();
    }

    /**
     * Registra acessos nos dias da semana
     * @return void
     */
    private function daily(): void
    {
        $dailyAccess = (array) json_decode($this->daily_access_register);

        $dailyAccess[strtolower(date("D"))]++;

        $this->daily_access_register = json_encode($dailyAccess);
    }

    /**
     * Reseta registro de acessos semanais
     * @return void
     */
    public function weeklyReset(): void
    {
        $this->weekly_access = 0;
        $this->daily_access_register = json_encode(self::weekDays);
        $this->week_started_in = date("Y-m-d H:i:s");
        $this->save();
    }
}
