<?php
/***********************************************************************************
 * X2CRM is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2016 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. on our website at www.x2crm.com, or at our
 * email address: contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 **********************************************************************************/

/**
 * Class to simplify web requests by abstracting creation of curl handles and stream contexts
 */

class RequestUtil extends CComponent {

    public $method = 'GET';
    public $header = array ();
    public $timeout = 5;
    public $url;
    public $multipart = false;
    private $_content = '';
    private $_header;

    public static function request ($options) {
        return AppFileUtil::getContents (
            Yii::createComponent (array_merge (array (
                'class' => get_class (),
            ), $options)));
    }

    public function setContent (array $content) {
        if ($this->method === 'POST' && $this->multipart)
            $this->_content = $content;
        else
            $this->_content = http_build_query ($content);
    }

    public function getContent () {
        return $this->_content;
    }

    /**
     * Magic getter to add default headers 
     */
    public function getHeader () {
        if (!isset ($this->_header)) {
            $header = $this->header;
            if ($this->method === 'POST' && $this->getContent ()) {
                if (!isset ($header['Content-Length']) && !$this->multipart) {
                    $header['Content-Length'] = strlen ($this->getContent ());
                }
                if (!isset ($header['Content-Type'])) {
                    $header['Content-Type'] = 'application/x-www-form-urlencoded';
                }
            }
            $this->_header = $header;
        }
        return $this->_header;
    }

    /**
     * Get stream context with specified request configuration 
     */
    public function getStreamContext () {
        $content = $this->getContent();
        if ($this->multipart)
            $content = $this->assembleMultipartContent ($content);

        if ($this->method === 'POST') {
        } else if ($this->method === 'GET' && $this->getContent ()) {
            $this->url .= (strpos ($this->url, '?') === false ? '?' : '&').$this->getContent ();
        }
        $header = array ();
        foreach ($this->getHeader () as $name => $val) {
            $header[] = $name.': '.$val;
        }

        $options = array (
            'http' => array (
                'method' => $this->method,
                'timeout' => $this->timeout,
                'header' => $header,
                'content' => $content,
            ));
        if ($this->multipart)
            $options['http']['follow_location'] = 0;

        return stream_context_create ($options);
    }

    /**
     * Get curl handle with specified request configuration 
     */
    public function getCurlHandle () {
        $ch = curl_init($this->url);
        $curlopt = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_POST => $this->method === 'POST',
            CURLOPT_TIMEOUT => $this->timeout
        );
        $curlopt[CURLOPT_HTTPHEADER] = $this->getHeader ();
        if ($this->method === 'POST')
            $curlopt[CURLOPT_POSTFIELDS] = $this->getContent ();

        curl_setopt_array($ch, $curlopt);
        return $ch;
    }

    /**
     * Assemble multipart body content as demonstrated here: https://stackoverflow.com/a/4247082
     */
    private function assembleMultipartContent($content) {
        $boundry = '--------------------------'.microtime(true);
        $this->header['Content-Type'] = 'multipart/form-data; boundary='.$boundry;
        $mpContent = '';
        foreach ($content as $key => $value) {
            $mpContent .= '--'.$boundry."\r\n".
                          "Content-Disposition: form-data; name=\"$key\"\r\n\r\n".
                          "$value\r\n";
        }
        $mpContent .= '--'.$boundry."--\r\n";
        return $mpContent;
    }
}

?>
