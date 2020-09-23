<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestData;
use App\Models\TestDataJoin;

class HomeController extends Controller
{
    public function index() {
        return number_format(microtime(true) - LARAVEL_START, 3);
    }
    
    public function db(Request $request) {
        $json = [];
        
        $total = 0;
        $server = (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '?') . '@' . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '?' );

        $line = str_pad("-",38,"-");
        
        $return = "<pre>$line\n|".str_pad("PHP BENCHMARK SCRIPT",36," ",STR_PAD_BOTH)."|\n$line\nStart : ".date("Y-m-d H:i:s")."\nServer : $server\nPHP version : ".PHP_VERSION."\nPlatform : ".PHP_OS. "\nBoot time : ". number_format(microtime(true) - LARAVEL_START, 3). "\n$line\n";
        
        $json['start'] = date("Y-m-d H:i:s");
        $json['server'] = (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '?');
        $json['server_ip'] = (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '?' );
        $json['php_version'] = PHP_VERSION;
        $json['php_os'] = PHP_OS;
        $json['boot_time'] = number_format(microtime(true) - LARAVEL_START, 3);
        
        $this->cleanData();
        
        $result = $this->insertRows();
        $total += $result;
        $return .= "insertRows : " . $result ." sec.\n";
        $json['insertRows'] = $result;
        
        
        $result = $this->singleRowSelect();
        $total += $result;
        $return .= "singleRowSelect : " . $result ." sec.\n";
        $json['singleRowSelect'] = $result;
        
        
        
        $result = $this->multiRowSelect();
        $total += $result;
        $return .= "multiRowSelect : " . $result ." sec.\n";
        $json['multiRowSelect'] = $result;
        
        
        
        $result = $this->multiSearchRowSelect();
        $total += $result;
        $return .= "multiSearchRowSelect : " . $result ." sec.\n";
        $json['multiSearchRowSelect'] = $result;
        
        
        
        $result = $this->multiManyRowSelect();
        $total += $result;
        $return .= "multiManyRowSelect : " . $result ." sec.\n";
        $json['multiManyRowSelect'] = $result;
        
        
        
        $result = $this->cleanData();
        $total += $result;
        $return .= "deleteData : " . $result ." sec.\n";
        $json['deleteData'] = $result;
        
        
        $return .= str_pad("-", 38, "-") . "\n" . str_pad("Total time:", 25) . " : " . $total ." sec.</pre>";
        $json['total'] = $total;
        $json['end_time'] = number_format(microtime(true) - LARAVEL_START, 3);
        
        
        if($request->get('format') === 'json') {
            return $json;
        }
        return $return;
    }
    
    private function cleanData() {
        $time_start = microtime(true);
        TestDataJoin::where('id', '<>', 0)->delete();
        TestData::where('id', '<>', 0)->delete();
        return number_format(microtime(true) - $time_start, 3);
    }
    
    private function insertRows() {
        $time_start = microtime(true);
        
        for($i = 0; $i < 5000; $i++) {
            $testData = TestData::create([
                'string1' => $i > 1000 && $i < 2000 ? 'String 1' : 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                'string2' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                'string3' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                'string4' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                'string5' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                'data' => '',
                'number1' => $i,
                'number2' => rand(0, 100000),
                'number3' => rand(0, 100000),
                'number4' => rand(0, 100000),
                'number5' => rand(0, 100000),
            ]);
            if($i < 1000) {
                $testData->testDataJoins()->create([
                    'string1' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                    'string2' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                    'string3' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                    'string4' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                    'string5' => 'Egestas Pharetra Tellus Pellentesque Ullamcorper',
                    'data' => '',
                    'number1' => rand(0, 100000),
                    'number2' => rand(0, 100000),
                    'number3' => rand(0, 100000),
                    'number4' => rand(0, 100000),
                    'number5' => rand(0, 100000),
                ]);
            }
        }
        
        return number_format(microtime(true) - $time_start, 3);
    }
    
    private function singleRowSelect() {
        $time_start = microtime(true);
        
        TestData::with('testDataJoins')->first();
        
        return number_format(microtime(true) - $time_start, 3);
    }
    
    private function multiRowSelect() {
        $time_start = microtime(true);
        
        TestData::all();
        
        return number_format(microtime(true) - $time_start, 3);
    }
    
    private function multiSearchRowSelect() {
        $time_start = microtime(true);
        
        TestData::where('string1', 'String 1')->get();
        
        return number_format(microtime(true) - $time_start, 3);
    }
    
    private function multiManyRowSelect() {
        $time_start = microtime(true);
        
        for($i = 0; $i < 5000; $i++) {
            TestData::where('number1', $i)->first();
        }
        
        return number_format(microtime(true) - $time_start, 3);
    }
}
