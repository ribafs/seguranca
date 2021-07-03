<?php

namespace Hp;

//  PROJECT HONEY POT ADDRESS DISTRIBUTION SCRIPT
//  For more information visit: http://www.projecthoneypot.org/
//  Copyright (C) 2004-2021, Unspam Technologies, Inc.
//
//  This program is free software; you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation; either version 2 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
//  02111-1307  USA
//
//  If you choose to modify or redistribute the software, you must
//  completely disconnect it from the Project Honey Pot Service, as
//  specified under the Terms of Service Use. These terms are available
//  here:
//
//  http://www.projecthoneypot.org/terms_of_service_use.php
//
//  The required modification to disconnect the software from the
//  Project Honey Pot Service is explained in the comments below. To find the
//  instructions, search for:  *** DISCONNECT INSTRUCTIONS ***
//
//  Generated On: Sat, 20 Feb 2021 07:46:33 -0500
//  For Domain: www.despertai.net.br
//
//

//  *** DISCONNECT INSTRUCTIONS ***
//
//  You are free to modify or redistribute this software. However, if
//  you do so you must disconnect it from the Project Honey Pot Service.
//  To do this, you must delete the lines of code below located between the
//  *** START CUT HERE *** and *** FINISH CUT HERE *** comments. Under the
//  Terms of Service Use that you agreed to before downloading this software,
//  you may not recreate the deleted lines or modify this software to access
//  or otherwise connect to any Project Honey Pot server.
//
//  *** START CUT HERE ***

define('__REQUEST_HOST', 'hpr4.projecthoneypot.org');
define('__REQUEST_PORT', '80');
define('__REQUEST_SCRIPT', '/cgi/serve.php');

//  *** FINISH CUT HERE ***

interface Response
{
    public function getBody();
    public function getLines(): array;
}

class TextResponse implements Response
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getBody()
    {
        return $this->content;
    }

    public function getLines(): array
    {
        return explode("\n", $this->content);
    }
}

interface HttpClient
{
    public function request(string $method, string $url, array $headers = [], array $data = []): Response;
}

class ScriptClient implements HttpClient
{
    private $proxy;
    private $credentials;

    public function __construct(string $settings)
    {
        $this->readSettings($settings);
    }

    private function getAuthorityComponent(string $authority = null, string $tag = null)
    {
        if(is_null($authority)){
            return null;
        }
        if(!is_null($tag)){
            $authority .= ":$tag";
        }
        return $authority;
    }

    private function readSettings(string $file)
    {
        if(!is_file($file) || !is_readable($file)){
            return;
        }

        $stmts = file($file);

        $settings = array_reduce($stmts, function($c, $stmt){
            list($key, $val) = \array_pad(array_map('trim', explode(':', $stmt)), 2, null);
            $c[$key] = $val;
            return $c;
        }, []);

        $this->proxy       = $this->getAuthorityComponent($settings['proxy_host'], $settings['proxy_port']);
        $this->credentials = $this->getAuthorityComponent($settings['proxy_user'], $settings['proxy_pass']);
    }

    public function request(string $method, string $uri, array $headers = [], array $data = []): Response
    {
        $options = [
            'http' => [
                'method' => strtoupper($method),
                'header' => $headers + [$this->credentials ? 'Proxy-Authorization: Basic ' . base64_encode($this->credentials) : null],
                'proxy' => $this->proxy,
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $body = file_get_contents($uri, false, $context);

        if($body === false){
            trigger_error(
                "Unable to contact the Server. Are outbound connections disabled? " .
                "(If a proxy is required for outbound traffic, you may configure " .
                "the honey pot to use a proxy. For instructions, visit " .
                "http://www.projecthoneypot.org/settings_help.php)",
                E_USER_ERROR
            );
        }

        return new TextResponse($body);
    }
}

trait AliasingTrait
{
    private $aliases = [];

    public function searchAliases($search, array $aliases, array $collector = [], $parent = null): array
    {
        foreach($aliases as $alias => $value){
            if(is_array($value)){
                return $this->searchAliases($search, $value, $collector, $alias);
            }
            if($search === $value){
                $collector[] = $parent ?? $alias;
            }
        }

        return $collector;
    }

    public function getAliases($search): array
    {
        $aliases = $this->searchAliases($search, $this->aliases);
    
        return !empty($aliases) ? $aliases : [$search];
    }

    public function aliasMatch($alias, $key)
    {
        return $key === $alias;
    }

    public function setAlias($key, $alias)
    {
        $this->aliases[$alias] = $key;
    }

    public function setAliases(array $array)
    {
        array_walk($array, function($v, $k){
            $this->aliases[$k] = $v;
        });
    }
}

abstract class Data
{
    protected $key;
    protected $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function key()
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }
}

class DataCollection
{
    use AliasingTrait;

    private $data;

    public function __construct(Data ...$data)
    {
        $this->data = $data;
    }

    public function set(Data ...$data)
    {
        array_map(function(Data $data){
            $index = $this->getIndexByKey($data->key());
            if(is_null($index)){
                $this->data[] = $data;
            } else {
                $this->data[$index] = $data;
            }
        }, $data);
    }

    public function getByKey($key)
    {
        $key = $this->getIndexByKey($key);
        return !is_null($key) ? $this->data[$key] : null;
    }

    public function getValueByKey($key)
    {
        $data = $this->getByKey($key);
        return !is_null($data) ? $data->value() : null;
    }

    private function getIndexByKey($key)
    {
        $result = [];
        array_walk($this->data, function(Data $data, $index) use ($key, &$result){
            if($data->key() == $key){
                $result[] = $index;
            }
        });

        return !empty($result) ? reset($result) : null;
    }
}

interface Transcriber
{
    public function transcribe(array $data): DataCollection;
    public function canTranscribe($value): bool;
}

class StringData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }
}

class CompressedData extends Data
{
    public function __construct($key, string $value)
    {
        parent::__construct($key, $value);
    }

    public function value()
    {
        $url_decoded = base64_decode(str_replace(['-','_'],['+','/'],$this->value));
        if(substr(bin2hex($url_decoded), 0, 6) === '1f8b08'){
            return gzdecode($url_decoded);
        } else {
            return $this->value;
        }
    }
}

class FlagData extends Data
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function value()
    {
        return $this->value ? ($this->data ?? null) : null;
    }
}

class CallbackData extends Data
{
    private $arguments = [];

    public function __construct($key, callable $value)
    {
        parent::__construct($key, $value);
    }

    public function setArgument($pos, $param)
    {
        $this->arguments[$pos] = $param;
    }

    public function value()
    {
        ksort($this->arguments);
        return \call_user_func_array($this->value, $this->arguments);
    }
}

class DataFactory
{
    private $data;
    private $callbacks;

    private function setData(array $data, string $class, DataCollection $dc = null)
    {
        $dc = $dc ?? new DataCollection;
        array_walk($data, function($value, $key) use($dc, $class){
            $dc->set(new $class($key, $value));
        });
        return $dc;
    }

    public function setStaticData(array $data)
    {
        $this->data = $this->setData($data, StringData::class, $this->data);
    }

    public function setCompressedData(array $data)
    {
        $this->data = $this->setData($data, CompressedData::class, $this->data);
    }

    public function setCallbackData(array $data)
    {
        $this->callbacks = $this->setData($data, CallbackData::class, $this->callbacks);
    }

    public function fromSourceKey($sourceKey, $key, $value)
    {
        $keys = $this->data->getAliases($key);
        $key = reset($keys);
        $data = $this->data->getValueByKey($key);

        switch($sourceKey){
            case 'directives':
                $flag = new FlagData($key, $value);
                if(!is_null($data)){
                    $flag->setData($data);
                }
                return $flag;
            case 'email':
            case 'emailmethod':
                $callback = $this->callbacks->getByKey($key);
                if(!is_null($callback)){
                    $pos = array_search($sourceKey, ['email', 'emailmethod']);
                    $callback->setArgument($pos, $value);
                    $this->callbacks->set($callback);
                    return $callback;
                }
            default:
                return new StringData($key, $value);
        }
    }
}

class DataTranscriber implements Transcriber
{
    private $template;
    private $data;
    private $factory;

    private $transcribingMode = false;

    public function __construct(DataCollection $data, DataFactory $factory)
    {
        $this->data = $data;
        $this->factory = $factory;
    }

    public function canTranscribe($value): bool
    {
        if($value == '<BEGIN>'){
            $this->transcribingMode = true;
            return false;
        }

        if($value == '<END>'){
            $this->transcribingMode = false;
        }

        return $this->transcribingMode;
    }

    public function transcribe(array $body): DataCollection
    {
        $data = $this->collectData($this->data, $body);

        return $data;
    }

    public function collectData(DataCollection $collector, array $array, $parents = []): DataCollection
    {
        foreach($array as $key => $value){
            if($this->canTranscribe($value)){
                $value = $this->parse($key, $value, $parents);
                $parents[] = $key;
                if(is_array($value)){
                    $this->collectData($collector, $value, $parents);
                } else {
                    $data = $this->factory->fromSourceKey($parents[1], $key, $value);
                    if(!is_null($data->value())){
                        $collector->set($data);
                    }
                }
                array_pop($parents);
            }
        }
        return $collector;
    }

    public function parse($key, $value, $parents = [])
    {
        if(is_string($value)){
            if(key($parents) !== NULL){
                $keys = $this->data->getAliases($key);
                if(count($keys) > 1 || $keys[0] !== $key){
                    return \array_fill_keys($keys, $value);
                }
            }

            end($parents);
            if(key($parents) === NULL && false !== strpos($value, '=')){
                list($key, $value) = explode('=', $value, 2);
                return [$key => urldecode($value)];
            }

            if($key === 'directives'){
                return explode(',', $value);
            }

        }

        return $value;
    }
}

interface Template
{
    public function render(DataCollection $data): string;
}

class ArrayTemplate implements Template
{
    public $template;

    public function __construct(array $template = [])
    {
        $this->template = $template;
    }

    public function render(DataCollection $data): string
    {
        $output = array_reduce($this->template, function($output, $key) use($data){
            $output[] = $data->getValueByKey($key) ?? null;
            return $output;
        }, []);
        ksort($output);
        return implode("\n", array_filter($output));
    }
}

class Script
{
    private $client;
    private $transcriber;
    private $template;
    private $templateData;
    private $factory;

    public function __construct(HttpClient $client, Transcriber $transcriber, Template $template, DataCollection $templateData, DataFactory $factory)
    {
        $this->client = $client;
        $this->transcriber = $transcriber;
        $this->template = $template;
        $this->templateData = $templateData;
        $this->factory = $factory;
    }

    public static function run(string $host, int $port, string $script, string $settings = '')
    {
        $client = new ScriptClient($settings);

        $templateData = new DataCollection;
        $templateData->setAliases([
            'doctype'   => 0,
            'head1'     => 1,
            'robots'    => 8,
            'nocollect' => 9,
            'head2'     => 1,
            'top'       => 2,
            'legal'     => 3,
            'style'     => 5,
            'vanity'    => 6,
            'bottom'    => 7,
            'emailCallback' => ['email','emailmethod'],
        ]);

        $factory = new DataFactory;
        $factory->setStaticData([
            'doctype' => '<!DOCTYPE html>',
            'head1'   => '<html><head>',
            'head2'   => '<title>Www.despertai.net.br Participial Polymorphous</title></head>',
            'top'     => '<body><div align="center">',
            'bottom'  => '</div></body></html>',
        ]);
        $factory->setCompressedData([
            'robots'    => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VSrKT8ovKVZSSM7PK0nNK7FVystPLErOyCxLVbKzwa8uMy8ltYKAqrT8nJz8ciU7AI6l-bpzAAAA',
            'nocollect' => 'H4sIAAAAAAAAA7PJTS1JVMhLzE21VcrL103NTczM0U3Oz8lJTS7JzM9TUkjOzytJzSuxVdJXsgMAKsBXli0AAAA',
            'legal'     => 'H4sIAAAAAAAAA7Vaa3PbNhb9vr8C6-x4k5nEsV0nsZeuZ1RHSbSTyllJSScfIRKS0FCACoB21F-_9wGQlEyz6TbbGTcSBYLAfZxz7gUvg5yXSuSqLP1G5tosfzw4PqDvG1kU6fvcukI5_Hh1GdzV3y5DcXVZ6Fvhw7ZUPx4srAnPFnKty-2_RG4rp5V7KtbWWJxVZQdXh2buN9nl_OoSx8KY0rofH72h_66Wl8_x6tXl8_k3Duz4bXVvEv6_uJy7elZ3NVspcacOH12cZx6_h8NHJycnmdjaStAFG1bKiaDw8y_q8u_Pngk598rkSpTybqucF2Gl8y9iYZ3SSyPm0nwRz55dzb2GuzpWlqeVwYxOyQLup9nlUpngu-7w8Q5LK1yp9eGjs5eZmK3wu7HmWXAS132c8Srx0bTSQgYpFpVZVl5s5AY2AgtTRziqMYN4wLrqYQt2js873NY29eGj8x-yjcq1LMkJY8trfvaugg1dvIqDTk5eZBsN8eWf4oWNw2HHP2S0xeMLdhNt91UWLN8ZdNrScC11KWSBn0eha5lf4jJ1p6lD_NWxqzfVvNS5KHRZ3eK6g7Wl2Di11tVaqK955RWalJZUWqPYMZ_jTo7PMukFrVDggs8zib_4YB3NXn21Dmct7cbDjgvIHxm0NfCv2hT2zuDcEBYw61ltHZikrDoDaxPXziGMzz_N0vM0b0cG5YwOW5zYLAWHncOhJ5laK7MXGZ3_0Ji-jEM3yHzVNUbHMRvp-NlSG1qZtxsnjTYWV-YDPeTxweGjV2dZVegcV_gii-EvnFqSwz1HQb5C6x6DYfD7RVYHyHFWCAj6RTLdSbYQCwWhRSMMXDqFVJe0gFL_VukCn44PO3mZ6TpmFV44y255ETnnD65DznnW2281W5MMnwFfcmsomNdyK-RmwyAwh5A6EjP8_ImdVui1NlXQtxRqnlcBLvXpqZ9G09HsZjLFzx8Gk9lnccM3KjBzAK8GMa9cuRUbq00olfc40QSHTz_-NB3-5-Pho5dstsvnAOPwfwD0_wHVHwCGL_eA4SEIWdwf2Q46-ANMFQvHZl8nv77K5r-qPIhAkLr2ghHD3pJJEcohHC4uwHVkbpFLpxYVfl4g-ArdgCc4Nc_BQhReC-XIxRBaKi2A_74RAMWfR8yrKX6rA4oiT_ngYvDRFo34pAHibRNScxsALnswQTdjC-U1G8jQrnJZltuaEwoHu1eeDJ6znZeGH_474wRhq2W7g7W-sPF4KP4E6CSMDa2AJwQ0xXPrWhfDiqfznViWYkZyrmkvgNboc-_olPXqa2dKfiPhfRMZpgcAmMpl9JNKEgKQXwnLQBLZvRSDPOjGTIDxDiAfUo-BzQuISsABsq5b009oHxPvrvfGsgSEhotOWDb7JFjhZ5gYzpE9E8b3QtUDhrE9hilahklzI-JEIdU3HckX6YSP6azu8ALkI8D-D1kRtx-a1col6y9QonkAAxll81J6jwxdgQRbAoUAVdvfKlwBMKpEoHNKiSbBH2Kv5ODB28lwyPibghcogABy_Ho0fstZ-eo8m6HrXmaTIXnw-v-GnvfVsOiO6bZf70CSrsS2IT6RYlEsyIY5WqoQdyuQBn6FZiI0AXFgOGD6GF7mpMw6UzFhGuCqV0kHnWeAMGJgaEFgFF1UsmxW6yIerYJvAcRdZLpVrWdQ8e3h8Ac0_6tsRE4Av7zsXHgK0vftKAWh5QXkEe3bs3Ijz4KgJpSNEYgy4ThLehTkuu2FoDxvLzHmomC0e5H5HQSUnCfHrO7uSlUsO9GwaKMhETjcm4x7nGngBz0nQiuKmOkI4gQrOvCFf_oIKKyqYZJy2_Us2ZJxPWRn_2R1oLu47lsH8kpo10HUtYIT2qCIImcdPBF-xUFVgF5CkyT7n2alVuQ3RGftVPfG85Z8ZjUEapxNBiM5_AigAgC-ZHeaJEMJqWKSxYyLSHj0B4Z8WPN05rfkGgBKcbFtyGTFIhoFH1cQhQUjSKxSdchXW2EkCcgCdENZVh6GKBK7wEEpB3hHC_4HSkX-wAUZUQ4EqxVVcwH_3g1m4t1gAiD5slXuDcafxc_DacTKU8qri-xNX207ezf86xC6H4iz4eTnHT1Vy5aoBylFytKyz6NPuS7KKc1sO1-ViyWokA_RSIKBsQUcPXuRQW2LQx8jvkBM3HG286xIV0BjfVZp0xDhd4xH9XWzB4Sj6-F4OtzJrkl751zl-MpvlPEYClK7jXXwYKeDBg2I0cC33mr2cRMALzPKnXcV71-CAKXp1tIYUjFLW1I4tWSmsyBKeSICTjDnU6jc6uytsxolvXQNNgFvCBUf1NR9pmhkVjPWiI9T8Y8XYNzzrNZeL7LYWRCp6MOfjsQIrM1ygpsEDJ4F46Fdpe1eQHbVNFMbc_Dhw_vR9WBfnB9nW66sHQQh1iB30m3FsjJ-BflyizIdU9VZKOAM9wp6oMdXOpCxDEyl0y4oRsVciWXDhLxdTurrViEA1byKxiP21WHVuBHmCiS6HBDtna7RKvIPlN0rvRbkQxXLnjywza3Zi7fJkLWYCwC12LgoS6F-q7BHgsaN3TDuOF3fTF6TjLqP6ZXrIxfwWM3BJ2dZXQtsZEvzVgZKdx5W0pqW6IoSy19lCurUxRZNJ7eqWrAkhpZpcUNa9Izk6PjtU3LEdPB2-JiuP-nrH9FQ0JEEQN8J1zAKx693Uvz6ZtyOSM9VAwKFJmgDdiwgAmPjMIIHNghjSuXWRAlB4cSFJc8Qb0_-L7k9aqkzSlIDJYS4c3ovMIbT2WREogysdJaR8dprdCBESs2lOBaxzosWauROggwi6i46C9okhXK73uw8Ot4Pok7zlhTnDVQLqYrek15KMi7AOi8yW_Ul5qKhfxC2DTyeZAlGGga1BpIgt8lEyosGxVTRlgM_vd8F7PcDWMqrjiyJuZ06U5Gw7yC5e9vFvG8WIg4Jf04C3AQJQPWYWwmABHMVqPJSYoDSicanlkgPxXGLeVFi2wzgD9hsjYmWomzA-AwOwbboBSsqnfelu-em61IG7CC4sLpTgC0BwBNPJbCUu92Ptps3Oxb8NKLUHM3aEWdUEB9izyjwRh9j2-cAP2-BxEAh1aUKEEKtoMUiTfF2APpkMhrj59mNgC9i1DjmplPZpNbLdDj59NchADb3ejQb3YynvbDTpqeGENa0PcNxeyRmKYRrT7_M1JH4aStYIUfi8TFGrOPRqIbowlMhqwCVI01KLgNQCFRFFiwca17hjgjwLjZi9303vkcKV29uJjTh3K7nSJwQPgtIIk1Jta6KlaKmeEeK8JLVA-WZaldQJmd2qwpurdO2QZ2sSIacxG4fhJx1EIztVaPWgVjfMNh2niAkyMBuDi8MYr8zT1PYK5QjUZ5RIxNJfaOkl3iLk4uQCMzRYVRs6RBGtqq9WsSfZ4m8a7yg9fZVe07l8Zxln-j3KeffHyejfRWUCFrQac3FRdYoNOmAUaKkjthLWwVo3ABWK1jPel1hvSYgC-VGrLdOSxKTkKIlycXUFzqgKr9Yt_AUwmFQsN4haJhCzdY-hSFAg4sxsA3IHgrhPKKUXcCa9-NysrNhCNIX2ZRb5LvXsXPXLi7AtEg3bBVsYYHc1AtaF5afmCV81mDnEEeQMnjq48DrGzyaA7WiUaBqVJDR4RCA9TlFvcy3vcQ4nd1MCJteD8ez0ZtR3dsftY4EgeklJNiyshUdBlzTqKPvAlPdaJiW93G3SIkI3dlKKuqC_Ow4O4iNkladIFoFGV6IarvJDgyZmXLr-PmXeM7LZ0ci0aNlTdzXe8NJ4AYcttaERmIvZsY342fvPv58LyboMCFpMrwwrzr3qmvUiIFJa-QNYgUl0tlvp15e1JaC3NuV6uCigAGFnyE7b_GcscUOReEiF3jGN7Aql3ZVqbBIgNRlUr-Izbd46Db3vClpIiUAeN6yxNK_Q3RLv2-i6WtKimsksZ1uMb5X0Of_OUX-wtl1n49Sg7PZnOXTHdYhRDUIDgf8fdo0dyjReuUfqkpmMnXU1xiNSrJG4rNeAUXRyCfBGhs1UJ6WpV5SxTKXzlGHG-MnHtgqPFQlnMGYcvtHUtS73MXqwU8x3Rr-8pHLAfDJ-JwEB53FTDKt5graUQXt-GBBemtqLTt-yzwKpdL5aTagleD1iYACZTob1av8i9jSFjb0mkPsZXusO29tSTrRB1floXLc0uA3N5CMY3fnj3s3j4EypKmb5y-IJab0qFtdlnKpBBS6DgBdBtIl1Efj8KAmJHUhlbvTnp_K-AtzKIe9laiFY3jafSTZFbSUM3i-u5MyIr7kgaEcj5n6Mqjkva81u1GyaMPqzmEpgJ0f5piWSEYqotWfZq5pNKY_DlaOobpBBUOBsFZVs-dUbal0fNdcYL0RywI8ghQFLS-0-xXLp_Est24bSXEbD9FKuXMYsMsotlqugpjztpqfZw1j2BrMAMTAcZbE_hPsXKQuSdRWGnmc9dnaAlvMLUTTRhqdQ5qCuEGULNKxeqNFqV3KMyF-NI0M_Im86PGhPWTANy-ZE6BGjzYRPdt2AO9HXHtxT1Nxz4-eh2WQDTsBN30znEzisdbs42zYWV0kehmMv28iHzwR2MxpmjsFNStMSyzy-z3YZXzCFE_pow6eHLUGzVX9LoX80tgZEjd2q3n7HPTVfLfbKRlI77BXZRf7pEWANr2vWDpbSclO1KM_zTZlLKjo8IHbR6jfsXVBUoLy_5dG0aS_wBRLW8fXjchjkLQ9hR_XLbFxy8CQPh-mIwwC7o2GvIkZZFjQmHjbiukbRQYw8lOuw7QrvNpivONrRGw4SllwEyLYrr3aMcmTVt0vAiVk2tTHWKcZ42MLUlzbl5iF-9jnhWIo-xXCDJCYWpGVITpF7Of7XV3cgxl-hXj0pIAoO5VouqmK4Po8aUzWjRIbsWZfzETZKqh04-MCPv0BBAy8zlgMuPuGmdFpSJ9VBmL2rhk_uL4efpgNvm_uNUoQeSyy3c6LGXjlQwlEz41kqFRUq9XFCuuwfsksRk6XmdKrAJhlkQX4LJdJk1-UbI2HYigwcB8xpnFYSs0p_nSHR5ovEt8wabAkdkDvxSYNCInd4z7zhP-deZ0aapJm7D2wAV6kbNUUNs1DTIUCr0lL0TJdFXuw-w0S_iOJzi8kQWnIlT1Hqz_a3dgrpEmAq9f4dXw9FFi6dwXNc3pp9zm97Asf4Of_AlAcUHf5KwAA',
            'style'     => 'H4sIAAAAAAAAAyXMOwqAMAwA0KsIrtbP2opj7xE1hUJIJMmgiHdXcHnjm80vwgV6IzD5uDch0djmnFMR9rgK7c00HmcDWoE6A7ZgqLUkx9PDjpsoeBWOLIzpmYf_fAFl8Fc7WwAAAA',
            'vanity'    => 'H4sIAAAAAAAAA22Sb0_DIBDGv8qFvXXrnLpkrG2My4wx0S3-eeFLWliLIkeOc3XfXlrnGzXkgAvwe54DclaVM1Ab52JQtfVNIaaiT4PS-phWSNpQP4t8cKYQlarfGsIPr-VosVgsO6u5lbOzafhcijJnSqFhr5xtfCEYw8_BI1TCafiEWYqLFOfp1LfEmGzTsozorB62jFarVU9M3jwcGTv0LCt0Gno9UGSVO4nKx3E0ZHfLGh2SHM3n82VSlr2ngNGyRS_JOMV2bxLzMs96aplnrP_YhePcmR0L-GX-LKlOUzv_rlZBS2ZXiJY5yCzrum4SCF9NzS16cwjIE6QmE1A7FWMhYhowdaK8W99drR9gcw3bh83tevUEN5v79QtsN095psq8on_pHz4Zf5_U-C7-IB_TCtwo2pvIhmBLyMlIKh3uDXdIbz002dtbbTRUB3geYIPccBFZ_3jZ8CvKL72pZ7IdAgAA',
        ]);
        $factory->setCallbackData([
            'emailCallback' => function($email, $style = null){
                $value = $email;
                $display = 'style="display:' . ['none',' none'][random_int(0,1)] . '"';
                $style = $style ?? random_int(0,5);
                $props[] = "href=\"mailto:$email\"";
        
                $wrap = function($value, $style) use($display){
                    switch($style){
                        case 2: return "<!-- $value -->";
                        case 4: return "<span $display>$value</span>";
                        case 5:
                            $id = '6331r6z5sist';
                            return "<div id=\"$id\">$value</div>\n<script>document.getElementById('$id').innerHTML = '';</script>";
                        default: return $value;
                    }
                };
        
                switch($style){
                    case 0: $value = ''; break;
                    case 3: $value = $wrap($email, 2); break;
                    case 1: $props[] = $display; break;
                }
        
                $props = implode(' ', $props);
                $link = "<a $props>$value</a>";
        
                return $wrap($link, $style);
            }
        ]);

        $transcriber = new DataTranscriber($templateData, $factory);

        $template = new ArrayTemplate([
            'doctype',
            'injDocType',
            'head1',
            'injHead1HTMLMsg',
            'robots',
            'injRobotHTMLMsg',
            'nocollect',
            'injNoCollectHTMLMsg',
            'head2',
            'injHead2HTMLMsg',
            'top',
            'injTopHTMLMsg',
            'actMsg',
            'errMsg',
            'customMsg',
            'legal',
            'injLegalHTMLMsg',
            'altLegalMsg',
            'emailCallback',
            'injEmailHTMLMsg',
            'style',
            'injStyleHTMLMsg',
            'vanity',
            'injVanityHTMLMsg',
            'altVanityMsg',
            'bottom',
            'injBottomHTMLMsg',
        ]);

        $hp = new Script($client, $transcriber, $template, $templateData, $factory);
        $hp->handle($host, $port, $script);
    }

    public function handle($host, $port, $script)
    {
        $data = [
            'tag1' => '8ce1335a89da841a0280537566ec1ea1',
            'tag2' => '269cdce0bd2f40e1034fb28d04051cd9',
            'tag3' => '3649d4e9bcfd3422fb4f9d22ae0a2a91',
            'tag4' => md5_file(__FILE__),
            'version' => "php-".phpversion(),
            'ip'      => $_SERVER['REMOTE_ADDR'],
            'svrn'    => $_SERVER['SERVER_NAME'],
            'svp'     => $_SERVER['SERVER_PORT'],
            'sn'      => $_SERVER['SCRIPT_NAME']     ?? '',
            'svip'    => $_SERVER['SERVER_ADDR']     ?? '',
            'rquri'   => $_SERVER['REQUEST_URI']     ?? '',
            'phpself' => $_SERVER['PHP_SELF']        ?? '',
            'ref'     => $_SERVER['HTTP_REFERER']    ?? '',
            'uagnt'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ];

        $headers = [
            "User-Agent: PHPot {$data['tag2']}",
            "Content-Type: application/x-www-form-urlencoded",
            "Cache-Control: no-store, no-cache",
            "Accept: */*",
            "Pragma: no-cache",
        ];

        $subResponse = $this->client->request("POST", "http://$host:$port/$script", $headers, $data);
        $data = $this->transcriber->transcribe($subResponse->getLines());
        $response = new TextResponse($this->template->render($data));

        $this->serve($response);
    }

    public function serve(Response $response)
    {
        header("Cache-Control: no-store, no-cache");
        header("Pragma: no-cache");

        print $response->getBody();
    }
}

Script::run(__REQUEST_HOST, __REQUEST_PORT, __REQUEST_SCRIPT, __DIR__ . '/phpot_settings.php');

