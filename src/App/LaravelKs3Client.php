<?php

namespace link1st\Ks3\App;

use Config;

class LaravelKs3Client
{

    private $config;

    // 连接对象
    private $ks3_client = null;

    private $defined    = false;


    /**
     * 构造函数
     *
     * LaravelKs3Client constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $ks3_config   = Config::get('ks3');
        $this->config = $ks3_config;

        if ( ! $this->defined) {
            self::syncConfig($ks3_config);
            require_once(__DIR__."/ks3-php-sdk-master/Ks3Client.class.php");
        }

        $this->ks3_client = new \Ks3Client($ks3_config['ks3_access_key'], $ks3_config['ks3_secret_key'],
            $ks3_config['ks3_end_point']);

        if (empty($this->ks3_client)) {
            throw new \Exception('ks3连接失败!');
        }
    }


    /**
     * 同步配置文件
     *
     * @param $ks3_config
     */
    private static function syncConfig($ks3_config)
    {
        // 必须为true 否则返回错误
        if ( ! defined("KS3_API_VHOST")) {
            // 是否使用VHOST
            define("KS3_API_VHOST", $ks3_config['vhost']);
        }
        if ( ! defined("KS3_API_LOG")) {
            // 是否开启日志(写入日志文件)
            define("KS3_API_LOG", $ks3_config['log']);
        }
        if ( ! defined("KS3_API_DISPLAY_LOG")) {
            // 是否显示日志(直接输出日志)
            define("KS3_API_DISPLAY_LOG", $ks3_config['display_log']);
        }
        if ( ! defined("KS3_API_LOG_PATH")) {
            // 定义日志目录(默认是该项目log下)
            define("KS3_API_LOG_PATH", $ks3_config['log_path']);
        }
        if ( ! defined("KS3_API_USE_HTTPS")) {
            // 是否使用HTTPS
            define("KS3_API_USE_HTTPS", $ks3_config['use_https']);
        }
        if ( ! defined("KS3_API_DEBUG_MODE")) {
            // 是否开启curl debug模式
            define("KS3_API_DEBUG_MODE", $ks3_config['debug_mode']);
        }

        $ks3_config['defined'] = true;
    }


    /**
     * 上传文件
     * 5.3.7.1 通过内容上传
     * @link https://ks3.ksyun.com/doc/sdk/php.html
     *
     * @param string $file_path 需要上传文件路径
     * @param string $ks3Key    新的文件名
     *
     * @return array|null
     */
    public function putObjectByFile($file_path, $new_file_name)
    {
        $content = fopen($file_path, "r");
        $args    = [
            "Bucket"     => $this->config['ks3_bucket'],
            "Key"        => $new_file_name,
            "Content"    => [
                "content"       => $content,
                "seek_position" => 0
            ],
            "ACL"        => "public-read",
            "ObjectMeta" => [
                "Content-Type" => "binay/ocet-stream"
                //"Content-Length"=>4
            ],
            "UserMeta"   => [
                "x-kss-meta-test" => "video"
            ]
        ];

        try {
            $ks3Res = $this->ks3_client->putObjectByFile($args);
            if (empty($ks3Res['ETag'])) {
                throw new \Exception('ETag 不存在!');
            }

            $res = [
                'url'  => 'http://'.$this->config['ks3_bucket'].'.'.$this->config['ks3_end_point'].'/'.$new_file_name,
                'etag' => $ks3Res['ETag'],
            ];
        } catch (\Exception $e) {
            // 上传文件失败
        }

        return false;
    }


    public function test()
    {
        return 'test';
    }

}