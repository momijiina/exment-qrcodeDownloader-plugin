<?php
namespace App\Plugins\QrCodeDownload;

use Exceedone\Exment\Services\Plugin\PluginButtonBase;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Plugin extends PluginButtonBase
{
    /**
     * Plugin Button
     */
    public function execute()
    {
        // プロキシ環境を考慮したurlの取得
        $protocol = 'http://';
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $protocol = 'https://';
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            $protocol = 'https://';
        }

        //ID取得
        $id = $this->custom_value->id;
        //テーブル名取得
        $table_name = $this->custom_table->table_name;
        //Exmentインストール先にサブディレクトリを含む場合は追加してください。例 /exment/admin/data/
        $param1 = "/admin/data/";


        $url = $protocol . $_SERVER['HTTP_HOST'] . $param1 . $table_name . "/" .$id;

        //URLの場合
        $png = QrCode::format('png')->encoding('UTF-8')->size(300)->generate("$url");

        // 列(title)の値を取得 列などの値を取得する場合
        //$getValue = $this->custom_value->getValue('title');
        //$png = QrCode::format('png')->encoding('UTF-8')->size(300)->generate("$getValue");

        return [
            'fileBase64' => base64_encode($png),
            'fileContentType' => 'image/png',
            'fileName' => 'qrcode.png',
            'swaltext' => 'QRコードの作成が完了しました',
        ];
    }
}
