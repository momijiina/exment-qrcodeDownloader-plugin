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
        // 現在のURLを取得（必要に応じてカスタムURLでもOK）作成中です
        //$url = request()->input('currentUrl', 'https://example.com');

        // 列(title)の値を取得
        $getValue = $this->custom_value->getValue('title');
 
        $png = QrCode::format('png')->encoding('UTF-8')->size(300)->generate("$getValue");

        //URLの場合
        //$png = QrCode::format('png')->encoding('UTF-8')->size(300)->generate("$url");

        return [
            'fileBase64' => base64_encode($png),
            'fileContentType' => 'image/png',
            'fileName' => 'qrcode.png',
            'swaltext' => 'QRコードの作成が完了しました',
        ];
    }
}
