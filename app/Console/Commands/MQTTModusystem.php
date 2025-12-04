<?php
namespace App\Console\Commands;

use App\Models\ObjectMonitoring;
use App\Models\ObjectMonitoringCode;
use Illuminate\Console\Command;
use \PhpMqtt\Client\ConnectionSettings;
use \PhpMqtt\Client\MqttClient;

class MQTTModusystem extends Command
{
    protected $signature   = 'app:m-q-t-t-modusystem';
    protected $description = 'Command description';
    public function handle()
    {

        try {

            //  $certificatePath    = storage_path('app/public/certificates/mqtt-ca.crt');

            $server = config("services.modusystem.url");

            $port               = config("services.modusystem.port");
            $clientId           = rand(5, 15);
            $username           = config("services.modusystem.username");
            $password           = config("services.modusystem.password");
            $clean_session      = false;
            $mqtt_version       = MqttClient::MQTT_3_1;
            $connectionSettings = (new ConnectionSettings)
                ->setUsername($username)
                ->setPassword($password)
                //    ->setKeepAliveInterval(60)
                ->setTlsCertificateAuthorityFile("mqtt-ca.crt")
                ->setConnectTimeout(50)
                ->setUseTls(true);
            $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);
            $mqtt->connect($connectionSettings, $clean_session);
            $mqtt->subscribe(config("services.modusystem.topic"), function ($topic, $message) {

                $data_message = explode(" ", $message);
                $value        = $data_message[0] ?? 0;
                $dateTime     = substr($data_message[1], 0, 19);
                $dateTime     = str_replace("T", " ", $dateTime);

                $data_topic = explode('/', $topic);

                $uuid     = $data_topic[2] ?? 0;
                $category = $data_topic[4] ?? 0;
                $param01  = $data_topic[5] ?? 0;
                $param02  = $data_topic[6] ?? 0;

                $action = "Nothing";

                if ($category == 'version') {
                    $action = "Software version: " . $value;
                }

                if ($category == 'error') {
                    $action = "Error code: " . $value;
                    //Search for error code

                    $type = ObjectMonitoring::where('external_object_id', $uuid)->where('category', 'type')->first();
                    if (str_contains($type, 'kone')) {
                        $brand = "kone";
                    } elseif (str_contains($type, 'schindler')) {
                        $brand = "schindler";
                    } elseif (str_contains($type, 'otis')) {
                        $brand = "otis";
                    } elseif (str_contains($type, 'tci')) {
                        $brand = "tci";
                    }
                    $action_from_tabel = ObjectMonitoringCode::where('error_code', $value)->where('brand', $brand)->first();
                    $action            = $action_from_table?->description;
                    if (! $action) {
                        $action = "unknow error " . $value;
                    }

                }

                if ($category == 'type') {
                    $action = "Controller type: " . ucfirst($value);
                }

                if ($category == 'floor') {
                    $level  = $value;
                    $action = "actual floor in shaft: " . $value;
                }

                if ($category == 'stop') {
                    $level  = $value;
                    $action = "actual floor stopped: " . $value;
                }
                if ($category == 'error_msg') {
                    $action = "Error: " . $category;
                }

                if ($category == 'speed') {
                    switch ($value) {
                        case 0:
                            $action = "Slow speed";
                            break;
                        case 1:
                            $action = "Fast speed";
                            break;

                    }
                }

                if ($category == 'heartbeat') {
                    $action = "Heartbeat signal interval: " . $value . " minute(s)";
                }

                if ($category == 'direction') {
                    switch ($value) {
                        case 0:
                            $action = "Elevator stoped";
                            break;
                        case 2:
                            $action = "Elevator going down";
                            break;
                        case 3:
                            $action = "Elevator going down (slow)";
                            break;
                        case 4:
                            $action = "Elevator going up";
                            break;
                        case 5:
                            $action = "Elevator going up (slow)";
                            break;
                    }
                }

                if ($category == 'state') {
                    switch ($value) {
                        case 0:
                            $action = "Elevator running";
                            break;
                        case 1:
                            $action = "Elevator in inspection mode";
                            break;
                        case 2:
                            $action = "Elevator emergency";
                            break;
                        case 3:
                            $action = "Elevator in error";
                            break;
                    }
                }

                if ($category == 'Online') {
                    switch ($value) {
                        case 0:
                            $action = "Elevator online";
                            break;
                        case 1:
                            $action = "Elevator offline";
                            break;
                    }
                }

                if ($category == 'moving') {
                    switch ($value) {
                        case 0:
                            $action = "Elevator moving";
                            break;
                        case 1:
                            $action = "Elevator standing still";
                            break;
                    }
                }

                if ($category == 'connected') {
                    switch ($value) {
                        case 0:
                            $action = "Elevator connection disconnected";
                            break;
                        case 1:
                            $action = "Elevator connection connected ";
                            break;
                        case 2:
                            $action = "Elevator connection error";
                            break;
                    }
                }

                if ($category == 'connected') {
                    switch ($value) {
                        case 0:
                            $action = "Elevator connection connected";
                            break;
                        case 1:
                            $action = "Elevator connection disconnected";
                            break;
                        case 2:
                            $action = "Elevator connection error";
                            break;
                    }
                }

                if ($category == 'state') {
                    switch ($value) {
                        case 0:
                            $action = "Monitoring state inactive";
                            break;
                        case 1:
                            $action = "active";
                            break;
                        case 2:
                            $action = "temporarily suspended (maintenance) ";
                            break;
                        case 3:
                            $action = "long term suspended (repair)";
                            break;
                        case 4:
                            $action = "Monitoring state decommissioned";
                            break;

                    }

                }

                if ($category == 'doors') {
                    $level = $param01;
                    switch ($value) {
                        case 0:
                            $action = "Door " . $door . " opened";
                            break;
                        case 1:
                            $action = "Door " . $door . " closed";
                            break;
                        case 2:
                            $action = "Opening door " . $door;
                            break;
                        case 3:
                            $action = "Closing door: " . $door;
                            break;
                    }
                }

                $data_insert = ObjectMonitoring::updateOrCreate(
                    [
                        "category"           => $category,
                        "external_object_id" => $uuid,
                        "value"              => $value,
                        "param01"            => $param01,
                        "date_time"          => $dateTime,
                        "param02"            => $param02,
                        "action"             => $action ?? null,
                        "level"              => $level ?? null,
                        "door"               => $door ?? null,
                        "brand"              => "modusystem",
                    ],
                    [
                        "date_time" => $dateTime,
                        "param01"   => $param01,
                        "param02"   => $param02,
                        "value"     => $value,
                        "action"    => $action ?? null,
                        "level"     => $level ?? null,
                        "door"      => $door ?? null,
                        "brand"     => "modusystem",
                    ]
                );

            }, 0);

            $mqtt->loop(true);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}
