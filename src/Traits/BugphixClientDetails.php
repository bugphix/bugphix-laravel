<?php

namespace Bugphix\BugphixLaravel\Traits;

/**
 * File: Browser.php
 * Author: Chris Schuld (http://chrisschuld.com/)
 * Last Modified: December 17, 2019
 * @version 1.9.4
 *
 * Copyright 2019 Chris Schuld
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without
 * limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * Typical Usage:
 *
 *   $browser = new Browser();
 *   if( $browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2 ) {
 *    echo 'You have FireFox version 2 or greater';
 *   }
 *
 * User Agents Sampled from: http://www.useragentstring.com/
 *
 * This implementation is based on the original work from Gary White
 * http://apptools.com/phptools/browser/
 *
 */

trait BugphixClientDetails {

    private $_agent = '';
    private $_browser_name = '';
    private $_version = '';
    private $_platform = '';
    private $_os = '';
    private $_is_aol = false;
    private $_is_mobile = false;
    private $_is_tablet = false;
    private $_is_robot = false;
    private $_is_facebook = false;
    private $_aol_version = '';

    protected $BROWSER_UNKNOWN = 'unknown';
    protected $VERSION_UNKNOWN = 'unknown';

    protected $BROWSER_OPERA = 'Opera'; // http://www.opera.com/
    protected $BROWSER_OPERA_MINI = 'Opera Mini'; // http://www.opera.com/mini/
    protected $BROWSER_WEBTV = 'WebTV'; // http://www.webtv.net/pc/
    protected $BROWSER_EDGE = 'Edge'; // https://www.microsoft.com/edge
    protected $BROWSER_IE = 'Internet Explorer'; // http://www.microsoft.com/ie/
    protected $BROWSER_POCKET_IE = 'Pocket Internet Explorer'; // http://en.wikipedia.org/wiki/Internet_Explorer_Mobile
    protected $BROWSER_KONQUEROR = 'Konqueror'; // http://www.konqueror.org/
    protected $BROWSER_ICAB = 'iCab'; // http://www.icab.de/
    protected $BROWSER_OMNIWEB = 'OmniWeb'; // http://www.omnigroup.com/applications/omniweb/
    protected $BROWSER_FIREBIRD = 'Firebird'; // http://www.ibphoenix.com/
    protected $BROWSER_FIREFOX = 'Firefox'; // https://www.mozilla.org/en-US/firefox/
    protected $BROWSER_BRAVE = 'Brave'; // https://brave.com/
    protected $BROWSER_PALEMOON = 'Palemoon'; // https://www.palemoon.org/
    protected $BROWSER_ICEWEASEL = 'Iceweasel'; // http://www.geticeweasel.org/
    protected $BROWSER_SHIRETOKO = 'Shiretoko'; // http://wiki.mozilla.org/Projects/shiretoko
    protected $BROWSER_MOZILLA = 'Mozilla'; // http://www.mozilla.com/en-US/
    protected $BROWSER_AMAYA = 'Amaya'; // http://www.w3.org/Amaya/
    protected $BROWSER_LYNX = 'Lynx'; // http://en.wikipedia.org/wiki/Lynx
    protected $BROWSER_SAFARI = 'Safari'; // http://apple.com
    protected $BROWSER_IPHONE = 'iPhone'; // http://apple.com
    protected $BROWSER_IPOD = 'iPod'; // http://apple.com
    protected $BROWSER_IPAD = 'iPad'; // http://apple.com
    protected $BROWSER_CHROME = 'Chrome'; // http://www.google.com/chrome
    protected $BROWSER_ANDROID = 'Android'; // http://www.android.com/
    protected $BROWSER_GOOGLEBOT = 'GoogleBot'; // http://en.wikipedia.org/wiki/Googlebot
    protected $BROWSER_CURL = 'cURL'; // https://en.wikipedia.org/wiki/CURL
    protected $BROWSER_WGET = 'Wget'; // https://en.wikipedia.org/wiki/Wget
    protected $BROWSER_UCBROWSER = 'UCBrowser'; // https://www.ucweb.com/


    protected $BROWSER_YANDEXBOT = 'YandexBot'; // http://yandex.com/bots
    protected $BROWSER_YANDEXIMAGERESIZER_BOT = 'YandexImageResizer'; // http://yandex.com/bots
    protected $BROWSER_YANDEXIMAGES_BOT = 'YandexImages'; // http://yandex.com/bots
    protected $BROWSER_YANDEXVIDEO_BOT = 'YandexVideo'; // http://yandex.com/bots
    protected $BROWSER_YANDEXMEDIA_BOT = 'YandexMedia'; // http://yandex.com/bots
    protected $BROWSER_YANDEXBLOGS_BOT = 'YandexBlogs'; // http://yandex.com/bots
    protected $BROWSER_YANDEXFAVICONS_BOT = 'YandexFavicons'; // http://yandex.com/bots
    protected $BROWSER_YANDEXWEBMASTER_BOT = 'YandexWebmaster'; // http://yandex.com/bots
    protected $BROWSER_YANDEXDIRECT_BOT = 'YandexDirect'; // http://yandex.com/bots
    protected $BROWSER_YANDEXMETRIKA_BOT = 'YandexMetrika'; // http://yandex.com/bots
    protected $BROWSER_YANDEXNEWS_BOT = 'YandexNews'; // http://yandex.com/bots
    protected $BROWSER_YANDEXCATALOG_BOT = 'YandexCatalog'; // http://yandex.com/bots

    protected $BROWSER_SLURP = 'Yahoo! Slurp'; // http://en.wikipedia.org/wiki/Yahoo!_Slurp
    protected $BROWSER_W3CVALIDATOR = 'W3C Validator'; // http://validator.w3.org/
    protected $BROWSER_BLACKBERRY = 'BlackBerry'; // http://www.blackberry.com/
    protected $BROWSER_ICECAT = 'IceCat'; // http://en.wikipedia.org/wiki/GNU_IceCat
    protected $BROWSER_NOKIA_S60 = 'Nokia S60 OSS Browser'; // http://en.wikipedia.org/wiki/Web_Browser_for_S60
    protected $BROWSER_NOKIA = 'Nokia Browser'; // * all other WAP-based browsers on the Nokia Platform
    protected $BROWSER_MSN = 'MSN Browser'; // http://explorer.msn.com/
    protected $BROWSER_MSNBOT = 'MSN Bot'; // http://search.msn.com/msnbot.htm
    protected $BROWSER_BINGBOT = 'Bing Bot'; // http://en.wikipedia.org/wiki/Bingbot
    protected $BROWSER_VIVALDI = 'Vivaldi'; // https://vivaldi.com/
    protected $BROWSER_YANDEX = 'Yandex'; // https://browser.yandex.ua/

    protected $BROWSER_NETSCAPE_NAVIGATOR = 'Netscape Navigator'; // http://browser.netscape.com/ (DEPRECATED)
    protected $BROWSER_GALEON = 'Galeon'; // http://galeon.sourceforge.net/ (DEPRECATED)
    protected $BROWSER_NETPOSITIVE = 'NetPositive'; // http://en.wikipedia.org/wiki/NetPositive (DEPRECATED)
    protected $BROWSER_PHOENIX = 'Phoenix'; // http://en.wikipedia.org/wiki/History_of_Mozilla_Firefox (DEPRECATED)
    protected $BROWSER_PLAYSTATION = "PlayStation";
    protected $BROWSER_SAMSUNG = "SamsungBrowser";
    protected $BROWSER_SILK = "Silk";
    protected $BROWSER_I_FRAME = "Iframely";
    protected $BROWSER_COCOA = "CocoaRestClient";

    protected $PLATFORM_UNKNOWN = 'unknown';
    protected $PLATFORM_WINDOWS = 'Windows';
    protected $PLATFORM_WINDOWS_CE = 'Windows CE';
    protected $PLATFORM_APPLE = 'Apple';
    protected $PLATFORM_LINUX = 'Linux';
    protected $PLATFORM_OS2 = 'OS/2';
    protected $PLATFORM_BEOS = 'BeOS';
    protected $PLATFORM_IPHONE = 'iPhone';
    protected $PLATFORM_IPOD = 'iPod';
    protected $PLATFORM_IPAD = 'iPad';
    protected $PLATFORM_BLACKBERRY = 'BlackBerry';
    protected $PLATFORM_NOKIA = 'Nokia';
    protected $PLATFORM_FREEBSD = 'FreeBSD';
    protected $PLATFORM_OPENBSD = 'OpenBSD';
    protected $PLATFORM_NETBSD = 'NetBSD';
    protected $PLATFORM_SUNOS = 'SunOS';
    protected $PLATFORM_OPENSOLARIS = 'OpenSolaris';
    protected $PLATFORM_ANDROID = 'Android';
    protected $PLATFORM_PLAYSTATION = "Sony PlayStation";
    protected $PLATFORM_ROKU = "Roku";
    protected $PLATFORM_APPLE_TV = "Apple TV";
    protected $PLATFORM_TERMINAL = "Terminal";
    protected $PLATFORM_FIRE_OS = "Fire OS";
    protected $PLATFORM_SMART_TV = "SMART-TV";
    protected $PLATFORM_CHROME_OS = "Chrome OS";
    protected $PLATFORM_JAVA_ANDROID = "Java/Android";
    protected $PLATFORM_POSTMAN = "Postman";
    protected $PLATFORM_I_FRAME = "Iframely";

    protected $OPERATING_SYSTEM_UNKNOWN = 'unknown';

    /**
     * Class constructor
     * @param string $userAgent
     */
    public function __construct($userAgent = '')
    {
        if ($userAgent != '') {
            $this->setUserAgent($userAgent);
        } else {
            $this->reset();
            $this->determine();
        }
    }

    /**
     * Reset all properties
     */
    public function reset()
    {
        $this->_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $this->_browser_name = $this->BROWSER_UNKNOWN;
        $this->_version = $this->VERSION_UNKNOWN;
        $this->_platform = $this->PLATFORM_UNKNOWN;
        $this->_os = $this->OPERATING_SYSTEM_UNKNOWN;
        $this->_is_aol = false;
        $this->_is_mobile = false;
        $this->_is_tablet = false;
        $this->_is_robot = false;
        $this->_is_facebook = false;
        $this->_aol_version = $this->VERSION_UNKNOWN;
    }

    /**
     * Check to see if the specific browser is valid
     * @param string $browserName
     * @return bool True if the browser is the specified browser
     */
    function isBrowser($browserName)
    {
        return (0 == strcasecmp($this->_browser_name, trim($browserName)));
    }

    /**
     * The name of the browser.  All return types are from the class contants
     * @return string Name of the browser
     */
    public function getBrowser()
    {
        return $this->_browser_name;
    }

    /**
     * Set the name of the browser
     * @param $browser string The name of the Browser
     */
    public function setBrowser($browser)
    {
        $this->_browser_name = $browser;
    }

    /**
     * The name of the platform.  All return types are from the class contants
     * @return string Name of the browser
     */
    public function getPlatform()
    {
        return $this->_platform;
    }

    /**
     * Set the name of the platform
     * @param string $platform The name of the Platform
     */
    public function setPlatform($platform)
    {
        $this->_platform = $platform;
    }

    /**
     * The version of the browser.
     * @return string Version of the browser (will only contain alpha-numeric characters and a period)
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Set the version of the browser
     * @param string $version The version of the Browser
     */
    public function setVersion($version)
    {
        $this->_version = preg_replace('/[^0-9,.,a-z,A-Z-]/', '', $version);
    }

    /**
     * The version of AOL.
     * @return string Version of AOL (will only contain alpha-numeric characters and a period)
     */
    public function getAolVersion()
    {
        return $this->_aol_version;
    }

    /**
     * Set the version of AOL
     * @param string $version The version of AOL
     */
    public function setAolVersion($version)
    {
        $this->_aol_version = preg_replace('/[^0-9,.,a-z,A-Z]/', '', $version);
    }

    /**
     * Is the browser from AOL?
     * @return boolean True if the browser is from AOL otherwise false
     */
    public function isAol()
    {
        return $this->_is_aol;
    }

    /**
     * Is the browser from a mobile device?
     * @return boolean True if the browser is from a mobile device otherwise false
     */
    public function isMobile()
    {
        return $this->_is_mobile;
    }

    /**
     * Is the browser from a tablet device?
     * @return boolean True if the browser is from a tablet device otherwise false
     */
    public function isTablet()
    {
        return $this->_is_tablet;
    }

    /**
     * Is the browser from a robot (ex Slurp,GoogleBot)?
     * @return boolean True if the browser is from a robot otherwise false
     */
    public function isRobot()
    {
        return $this->_is_robot;
    }

    /**
     * Is the browser from facebook?
     * @return boolean True if the browser is from facebook otherwise false
     */
    public function isFacebook()
    {
        return $this->_is_facebook;
    }

    /**
     * Set the browser to be from AOL
     * @param $isAol
     */
    public function setAol($isAol)
    {
        $this->_is_aol = $isAol;
    }

    /**
     * Set the Browser to be mobile
     * @param boolean $value is the browser a mobile browser or not
     */
    protected function setMobile($value = true)
    {
        $this->_is_mobile = $value;
    }

    /**
     * Set the Browser to be tablet
     * @param boolean $value is the browser a tablet browser or not
     */
    protected function setTablet($value = true)
    {
        $this->_is_tablet = $value;
    }

    /**
     * Set the Browser to be a robot
     * @param boolean $value is the browser a robot or not
     */
    protected function setRobot($value = true)
    {
        $this->_is_robot = $value;
    }

    /**
     * Set the Browser to be a Facebook request
     * @param boolean $value is the browser a robot or not
     */
    protected function setFacebook($value = true)
    {
        $this->_is_facebook = $value;
    }

    /**
     * Get the user agent value in use to determine the browser
     * @return string The user agent from the HTTP header
     */
    public function getUserAgent()
    {
        return $this->_agent;
    }

    /**
     * Set the user agent value (the construction will use the HTTP header value - this will overwrite it)
     * @param string $agent_string The value for the User Agent
     */
    public function setUserAgent($agent_string)
    {
        $this->reset();
        $this->_agent = $agent_string;
        $this->determine();
    }

    /**
     * Used to determine if the browser is actually "chromeframe"
     * @since 1.7
     * @return boolean True if the browser is using chromeframe
     */
    public function isChromeFrame()
    {
        return (strpos($this->_agent, "chromeframe") !== false);
    }

    /**
     * Returns a formatted string with a summary of the details of the browser.
     * @return string formatted string with a summary of the browser
     */
    public function __toString()
    {
        return "<strong>Browser Name:</strong> {$this->getBrowser()}<br/>\n" .
            "<strong>Browser Version:</strong> {$this->getVersion()}<br/>\n" .
            "<strong>Browser User Agent String:</strong> {$this->getUserAgent()}<br/>\n" .
            "<strong>Platform:</strong> {$this->getPlatform()}<br/>";
    }

    /**
     * Protected routine to calculate and determine what the browser is in use (including platform)
     */
    protected function determine()
    {
        // $this->checkPlatform();
        $this->checkSystemInfo();
        $this->checkBrowsers();
        $this->checkForAol();
    }

    /**
     * Protected routine to determine the browser type
     * @return boolean True if the browser was detected otherwise false
     */
    protected function checkBrowsers()
    {
        return (
            // well-known, well-used
            // Special Notes:
            // (1) Opera must be checked before FireFox due to the odd
            //     user agents used in some older versions of Opera
            // (2) WebTV is strapped onto Internet Explorer so we must
            //     check for WebTV before IE
            // (3) (deprecated) Galeon is based on Firefox and needs to be
            //     tested before Firefox is tested
            // (4) OmniWeb is based on Safari so OmniWeb check must occur
            //     before Safari
            // (5) Netscape 9+ is based on Firefox so Netscape checks
            //     before FireFox are necessary
            // (6) Vivaldi is UA contains both Firefox and Chrome so Vivaldi checks
            //     before Firefox and Chrome
            $this->checkBrowserWebTv() ||
            $this->checkBrowserBrave() ||
            $this->checkBrowserUCBrowser() ||
            $this->checkBrowserEdge() ||
            $this->checkBrowserInternetExplorer() ||
            $this->checkBrowserOpera() ||
            $this->checkBrowserGaleon() ||
            $this->checkBrowserNetscapeNavigator9Plus() ||
            $this->checkBrowserVivaldi() ||
            $this->checkBrowserYandex() ||
            $this->checkBrowserPalemoon() ||
            $this->checkBrowserFirefox() ||
            $this->checkBrowserChrome() ||
            $this->checkBrowserOmniWeb() ||

            // common mobile
            $this->checkBrowserAndroid() ||
            $this->checkBrowseriPad() ||
            $this->checkBrowseriPod() ||
            $this->checkBrowseriPhone() ||
            $this->checkBrowserBlackBerry() ||
            $this->checkBrowserNokia() ||

            // common bots
            $this->checkBrowserGoogleBot() ||
            $this->checkBrowserMSNBot() ||
            $this->checkBrowserBingBot() ||
            $this->checkBrowserSlurp() ||

            // Yandex bots
            $this->checkBrowserYandexBot() ||
            $this->checkBrowserYandexImageResizerBot() ||
            $this->checkBrowserYandexBlogsBot() ||
            $this->checkBrowserYandexCatalogBot() ||
            $this->checkBrowserYandexDirectBot() ||
            $this->checkBrowserYandexFaviconsBot() ||
            $this->checkBrowserYandexImagesBot() ||
            $this->checkBrowserYandexMediaBot() ||
            $this->checkBrowserYandexMetrikaBot() ||
            $this->checkBrowserYandexNewsBot() ||
            $this->checkBrowserYandexVideoBot() ||
            $this->checkBrowserYandexWebmasterBot() ||

            // check for facebook external hit when loading URL
            $this->checkFacebookExternalHit() ||

            // WebKit base check (post mobile and others)
            $this->checkBrowserSamsung() ||
            $this->checkBrowserSilk() ||
            $this->checkBrowserSafari() ||

            // everyone else
            $this->checkBrowserNetPositive() ||
            $this->checkBrowserFirebird() ||
            $this->checkBrowserKonqueror() ||
            $this->checkBrowserIcab() ||
            $this->checkBrowserPhoenix() ||
            $this->checkBrowserAmaya() ||
            $this->checkBrowserLynx() ||
            $this->checkBrowserShiretoko() ||
            $this->checkBrowserIceCat() ||
            $this->checkBrowserIceweasel() ||
            $this->checkBrowserW3CValidator() ||
            $this->checkBrowserCurl() ||
            $this->checkBrowserWget() ||
            $this->checkBrowserPlayStation() ||
            $this->checkBrowserIframely() ||
            $this->checkBrowserCocoa() ||
            $this->checkBrowserMozilla() /* Mozilla is such an open standard that you must check it last */);
    }

    /**
     * Determine if the user is using a BlackBerry (last updated 1.7)
     * @return boolean True if the browser is the BlackBerry browser otherwise false
     */
    protected function checkBrowserBlackBerry()
    {
        if (stripos($this->_agent, 'blackberry') !== false) {
            $aresult = explode('/', stristr($this->_agent, "BlackBerry"));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->_browser_name = $this->BROWSER_BLACKBERRY;
                $this->setMobile(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the user is using an AOL User Agent (last updated 1.7)
     * @return boolean True if the browser is from AOL otherwise false
     */
    protected function checkForAol()
    {
        $this->setAol(false);
        $this->setAolVersion($this->VERSION_UNKNOWN);

        if (stripos($this->_agent, 'aol') !== false) {
            $aversion = explode(' ', stristr($this->_agent, 'AOL'));
            if (isset($aversion[1])) {
                $this->setAol(true);
                $this->setAolVersion(preg_replace('/[^0-9\.a-z]/i', '', $aversion[1]));
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the GoogleBot or not (last updated 1.7)
     * @return boolean True if the browser is the GoogletBot otherwise false
     */
    protected function checkBrowserGoogleBot()
    {
        if (stripos($this->_agent, 'googlebot') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'googlebot'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_GOOGLEBOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexBot or not
     * @return boolean True if the browser is the YandexBot otherwise false
     */
    protected function checkBrowserYandexBot()
    {
        if (stripos($this->_agent, 'YandexBot') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexBot'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXBOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexImageResizer or not
     * @return boolean True if the browser is the YandexImageResizer otherwise false
     */
    protected function checkBrowserYandexImageResizerBot()
    {
        if (stripos($this->_agent, 'YandexImageResizer') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexImageResizer'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXIMAGERESIZER_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexCatalog or not
     * @return boolean True if the browser is the YandexCatalog otherwise false
     */
    protected function checkBrowserYandexCatalogBot()
    {
        if (stripos($this->_agent, 'YandexCatalog') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexCatalog'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXCATALOG_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexNews or not
     * @return boolean True if the browser is the YandexNews otherwise false
     */
    protected function checkBrowserYandexNewsBot()
    {
        if (stripos($this->_agent, 'YandexNews') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexNews'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXNEWS_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexMetrika or not
     * @return boolean True if the browser is the YandexMetrika otherwise false
     */
    protected function checkBrowserYandexMetrikaBot()
    {
        if (stripos($this->_agent, 'YandexMetrika') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexMetrika'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXMETRIKA_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexDirect or not
     * @return boolean True if the browser is the YandexDirect otherwise false
     */
    protected function checkBrowserYandexDirectBot()
    {
        if (stripos($this->_agent, 'YandexDirect') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexDirect'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXDIRECT_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexWebmaster or not
     * @return boolean True if the browser is the YandexWebmaster otherwise false
     */
    protected function checkBrowserYandexWebmasterBot()
    {
        if (stripos($this->_agent, 'YandexWebmaster') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexWebmaster'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXWEBMASTER_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexFavicons or not
     * @return boolean True if the browser is the YandexFavicons otherwise false
     */
    protected function checkBrowserYandexFaviconsBot()
    {
        if (stripos($this->_agent, 'YandexFavicons') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexFavicons'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXFAVICONS_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexBlogs or not
     * @return boolean True if the browser is the YandexBlogs otherwise false
     */
    protected function checkBrowserYandexBlogsBot()
    {
        if (stripos($this->_agent, 'YandexBlogs') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexBlogs'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXBLOGS_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexMedia or not
     * @return boolean True if the browser is the YandexMedia otherwise false
     */
    protected function checkBrowserYandexMediaBot()
    {
        if (stripos($this->_agent, 'YandexMedia') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexMedia'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXMEDIA_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexVideo or not
     * @return boolean True if the browser is the YandexVideo otherwise false
     */
    protected function checkBrowserYandexVideoBot()
    {
        if (stripos($this->_agent, 'YandexVideo') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexVideo'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXVIDEO_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the YandexImages or not
     * @return boolean True if the browser is the YandexImages otherwise false
     */
    protected function checkBrowserYandexImagesBot()
    {
        if (stripos($this->_agent, 'YandexImages') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YandexImages'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(';', '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_YANDEXIMAGES_BOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the MSNBot or not (last updated 1.9)
     * @return boolean True if the browser is the MSNBot otherwise false
     */
    protected function checkBrowserMSNBot()
    {
        if (stripos($this->_agent, "msnbot") !== false) {
            $aresult = explode("/", stristr($this->_agent, "msnbot"));
            if (isset($aresult[1])) {
                $aversion = explode(" ", $aresult[1]);
                $this->setVersion(str_replace(";", '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_MSNBOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the BingBot or not (last updated 1.9)
     * @return boolean True if the browser is the BingBot otherwise false
     */
    protected function checkBrowserBingBot()
    {
        if (stripos($this->_agent, "bingbot") !== false) {
            $aresult = explode("/", stristr($this->_agent, "bingbot"));
            if (isset($aresult[1])) {
                $aversion = explode(" ", $aresult[1]);
                $this->setVersion(str_replace(";", '', $aversion[0]));
                $this->_browser_name = $this->BROWSER_BINGBOT;
                $this->setRobot(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is the W3C Validator or not (last updated 1.7)
     * @return boolean True if the browser is the W3C Validator otherwise false
     */
    protected function checkBrowserW3CValidator()
    {
        if (stripos($this->_agent, 'W3C-checklink') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'W3C-checklink'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->_browser_name = $this->BROWSER_W3CVALIDATOR;
                return true;
            }
        } else if (stripos($this->_agent, 'W3C_Validator') !== false) {
            // Some of the Validator versions do not delineate w/ a slash - add it back in
            $ua = str_replace("W3C_Validator ", "W3C_Validator/", $this->_agent);
            $aresult = explode('/', stristr($ua, 'W3C_Validator'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->_browser_name = $this->BROWSER_W3CVALIDATOR;
                return true;
            }
        } else if (stripos($this->_agent, 'W3C-mobileOK') !== false) {
            $this->_browser_name = $this->BROWSER_W3CVALIDATOR;
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is the Yahoo! Slurp Robot or not (last updated 1.7)
     * @return boolean True if the browser is the Yahoo! Slurp Robot otherwise false
     */
    protected function checkBrowserSlurp()
    {
        if (stripos($this->_agent, 'slurp') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Slurp'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->_browser_name = $this->BROWSER_SLURP;
                $this->setRobot(true);
                $this->setMobile(false);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Brave or not
     * @return boolean True if the browser is Brave otherwise false
     */
    protected function checkBrowserBrave()
    {
        if (stripos($this->_agent, 'Brave/') !== false) {
            $aResult = explode('/', stristr($this->_agent, 'Brave'));
            if (isset($aResult[1])) {
                $aversion = explode(' ', $aResult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_BRAVE);
                return true;
            }
        } elseif (stripos($this->_agent, ' Brave ') !== false) {
            $this->setBrowser($this->BROWSER_BRAVE);
            // this version of the UA did not ship with a version marker
            // e.g. Mozilla/5.0 (Linux; Android 7.0; SM-G955F Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Brave Chrome/68.0.3440.91 Mobile Safari/537.36
            $this->setVersion('');
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Edge or not
     * @return boolean True if the browser is Edge otherwise false
     */
    protected function checkBrowserEdge()
    {
        if (stripos($this->_agent, 'Edge/') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Edge'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_EDGE);
                if (stripos($this->_agent, 'Windows Phone') !== false || stripos($this->_agent, 'Android') !== false) {
                    $this->setMobile(true);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Internet Explorer or not (last updated 1.7)
     * @return boolean True if the browser is Internet Explorer otherwise false
     */
    protected function checkBrowserInternetExplorer()
    {
        //  Test for IE11
        if (stripos($this->_agent, 'Trident/7.0; rv:11.0') !== false) {
            $this->setBrowser($this->BROWSER_IE);
            $this->setVersion('11.0');
            return true;
        } // Test for v1 - v1.5 IE
        else if (stripos($this->_agent, 'microsoft internet explorer') !== false) {
            $this->setBrowser($this->BROWSER_IE);
            $this->setVersion('1.0');
            $aresult = stristr($this->_agent, '/');
            if (preg_match('/308|425|426|474|0b1/i', $aresult)) {
                $this->setVersion('1.5');
            }
            return true;
        } // Test for versions > 1.5
        else if (stripos($this->_agent, 'msie') !== false && stripos($this->_agent, 'opera') === false) {
            // See if the browser is the odd MSN Explorer
            if (stripos($this->_agent, 'msnb') !== false) {
                $aresult = explode(' ', stristr(str_replace(';', '; ', $this->_agent), 'MSN'));
                if (isset($aresult[1])) {
                    $this->setBrowser($this->BROWSER_MSN);
                    $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
                    return true;
                }
            }
            $aresult = explode(' ', stristr(str_replace(';', '; ', $this->_agent), 'msie'));
            if (isset($aresult[1])) {
                $this->setBrowser($this->BROWSER_IE);
                $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
                if (stripos($this->_agent, 'IEMobile') !== false) {
                    $this->setBrowser($this->BROWSER_POCKET_IE);
                    $this->setMobile(true);
                }
                return true;
            }
        } // Test for versions > IE 10
        else if (stripos($this->_agent, 'trident') !== false) {
            $this->setBrowser($this->BROWSER_IE);
            $result = explode('rv:', $this->_agent);
            if (isset($result[1])) {
                $this->setVersion(preg_replace('/[^0-9.]+/', '', $result[1]));
                $this->_agent = str_replace(array("Mozilla", "Gecko"), "MSIE", $this->_agent);
            }
        } // Test for Pocket IE
        else if (stripos($this->_agent, 'mspie') !== false || stripos($this->_agent, 'pocket') !== false) {
            $aresult = explode(' ', stristr($this->_agent, 'mspie'));
            if (isset($aresult[1])) {
                $this->setPlatform($this->PLATFORM_WINDOWS_CE);
                $this->setBrowser($this->BROWSER_POCKET_IE);
                $this->setMobile(true);

                if (stripos($this->_agent, 'mspie') !== false) {
                    $this->setVersion($aresult[1]);
                } else {
                    $aversion = explode('/', $this->_agent);
                    if (isset($aversion[1])) {
                        $this->setVersion($aversion[1]);
                    }
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Opera or not (last updated 1.7)
     * @return boolean True if the browser is Opera otherwise false
     */
    protected function checkBrowserOpera()
    {
        if (stripos($this->_agent, 'opera mini') !== false) {
            $resultant = stristr($this->_agent, 'opera mini');
            if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', $resultant);
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    $this->setVersion($aversion[0]);
                }
            } else {
                $aversion = explode(' ', stristr($resultant, 'opera mini'));
                if (isset($aversion[1])) {
                    $this->setVersion($aversion[1]);
                }
            }
            $this->_browser_name = $this->BROWSER_OPERA_MINI;
            $this->setMobile(true);
            return true;
        } else if (stripos($this->_agent, 'opera') !== false) {
            $resultant = stristr($this->_agent, 'opera');
            if (preg_match('/Version\/(1*.*)$/', $resultant, $matches)) {
                $this->setVersion($matches[1]);
            } else if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', str_replace("(", " ", $resultant));
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    $this->setVersion($aversion[0]);
                }
            } else {
                $aversion = explode(' ', stristr($resultant, 'opera'));
                $this->setVersion(isset($aversion[1]) ? $aversion[1] : '');
            }
            if (stripos($this->_agent, 'Opera Mobi') !== false) {
                $this->setMobile(true);
            }
            $this->_browser_name = $this->BROWSER_OPERA;
            return true;
        } else if (stripos($this->_agent, 'OPR') !== false) {
            $resultant = stristr($this->_agent, 'OPR');
            if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', str_replace("(", " ", $resultant));
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    $this->setVersion($aversion[0]);
                }
            }
            if (stripos($this->_agent, 'Mobile') !== false) {
                $this->setMobile(true);
            }
            $this->_browser_name = $this->BROWSER_OPERA;
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Chrome or not (last updated 1.7)
     * @return boolean True if the browser is Chrome otherwise false
     */
    protected function checkBrowserChrome()
    {
        if (stripos($this->_agent, 'Chrome') !== false) {
            $aresult = preg_split('/[\/;]+/', stristr($this->_agent, 'Chrome'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_CHROME);
                //Chrome on Android
                if (stripos($this->_agent, 'Android') !== false) {
                    if (stripos($this->_agent, 'Mobile') !== false) {
                        $this->setMobile(true);
                    } else {
                        $this->setTablet(true);
                    }
                }
                return true;
            }
        }
        return false;
    }


    /**
     * Determine if the browser is WebTv or not (last updated 1.7)
     * @return boolean True if the browser is WebTv otherwise false
     */
    protected function checkBrowserWebTv()
    {
        if (stripos($this->_agent, 'webtv') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'webtv'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_WEBTV);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is NetPositive or not (last updated 1.7)
     * @return boolean True if the browser is NetPositive otherwise false
     */
    protected function checkBrowserNetPositive()
    {
        if (stripos($this->_agent, 'NetPositive') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'NetPositive'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion(str_replace(array('(', ')', ';'), '', $aversion[0]));
                $this->setBrowser($this->BROWSER_NETPOSITIVE);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Galeon or not (last updated 1.7)
     * @return boolean True if the browser is Galeon otherwise false
     */
    protected function checkBrowserGaleon()
    {
        if (stripos($this->_agent, 'galeon') !== false) {
            $aresult = explode(' ', stristr($this->_agent, 'galeon'));
            $aversion = explode('/', $aresult[0]);
            if (isset($aversion[1])) {
                $this->setVersion($aversion[1]);
                $this->setBrowser($this->BROWSER_GALEON);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Konqueror or not (last updated 1.7)
     * @return boolean True if the browser is Konqueror otherwise false
     */
    protected function checkBrowserKonqueror()
    {
        if (stripos($this->_agent, 'Konqueror') !== false) {
            $aresult = explode(' ', stristr($this->_agent, 'Konqueror'));
            $aversion = explode('/', $aresult[0]);
            if (isset($aversion[1])) {
                $this->setVersion($aversion[1]);
                $this->setBrowser($this->BROWSER_KONQUEROR);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is iCab or not (last updated 1.7)
     * @return boolean True if the browser is iCab otherwise false
     */
    protected function checkBrowserIcab()
    {
        if (stripos($this->_agent, 'icab') !== false) {
            $aversion = explode(' ', stristr(str_replace('/', ' ', $this->_agent), 'icab'));
            if (isset($aversion[1])) {
                $this->setVersion($aversion[1]);
                $this->setBrowser($this->BROWSER_ICAB);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is OmniWeb or not (last updated 1.7)
     * @return boolean True if the browser is OmniWeb otherwise false
     */
    protected function checkBrowserOmniWeb()
    {
        if (stripos($this->_agent, 'omniweb') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'omniweb'));
            $aversion = explode(' ', isset($aresult[1]) ? $aresult[1] : '');
            $this->setVersion($aversion[0]);
            $this->setBrowser($this->BROWSER_OMNIWEB);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Phoenix or not (last updated 1.7)
     * @return boolean True if the browser is Phoenix otherwise false
     */
    protected function checkBrowserPhoenix()
    {
        if (stripos($this->_agent, 'Phoenix') !== false) {
            $aversion = explode('/', stristr($this->_agent, 'Phoenix'));
            if (isset($aversion[1])) {
                $this->setVersion($aversion[1]);
                $this->setBrowser($this->BROWSER_PHOENIX);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Firebird or not (last updated 1.7)
     * @return boolean True if the browser is Firebird otherwise false
     */
    protected function checkBrowserFirebird()
    {
        if (stripos($this->_agent, 'Firebird') !== false) {
            $aversion = explode('/', stristr($this->_agent, 'Firebird'));
            if (isset($aversion[1])) {
                $this->setVersion($aversion[1]);
                $this->setBrowser($this->BROWSER_FIREBIRD);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Netscape Navigator 9+ or not (last updated 1.7)
     * NOTE: (http://browser.netscape.com/ - Official support ended on March 1st, 2008)
     * @return boolean True if the browser is Netscape Navigator 9+ otherwise false
     */
    protected function checkBrowserNetscapeNavigator9Plus()
    {
        if (stripos($this->_agent, 'Firefox') !== false && preg_match('/Navigator\/([^ ]*)/i', $this->_agent, $matches)) {
            $this->setVersion($matches[1]);
            $this->setBrowser($this->BROWSER_NETSCAPE_NAVIGATOR);
            return true;
        } else if (stripos($this->_agent, 'Firefox') === false && preg_match('/Netscape6?\/([^ ]*)/i', $this->_agent, $matches)) {
            $this->setVersion($matches[1]);
            $this->setBrowser($this->BROWSER_NETSCAPE_NAVIGATOR);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Shiretoko or not (https://wiki.mozilla.org/Projects/shiretoko) (last updated 1.7)
     * @return boolean True if the browser is Shiretoko otherwise false
     */
    protected function checkBrowserShiretoko()
    {
        if (stripos($this->_agent, 'Mozilla') !== false && preg_match('/Shiretoko\/([^ ]*)/i', $this->_agent, $matches)) {
            $this->setVersion($matches[1]);
            $this->setBrowser($this->BROWSER_SHIRETOKO);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Ice Cat or not (http://en.wikipedia.org/wiki/GNU_IceCat) (last updated 1.7)
     * @return boolean True if the browser is Ice Cat otherwise false
     */
    protected function checkBrowserIceCat()
    {
        if (stripos($this->_agent, 'Mozilla') !== false && preg_match('/IceCat\/([^ ]*)/i', $this->_agent, $matches)) {
            $this->setVersion($matches[1]);
            $this->setBrowser($this->BROWSER_ICECAT);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Nokia or not (last updated 1.7)
     * @return boolean True if the browser is Nokia otherwise false
     */
    protected function checkBrowserNokia()
    {
        if (preg_match("/Nokia([^\/]+)\/([^ SP]+)/i", $this->_agent, $matches)) {
            $this->setVersion($matches[2]);
            if (stripos($this->_agent, 'Series60') !== false || strpos($this->_agent, 'S60') !== false) {
                $this->setBrowser($this->BROWSER_NOKIA_S60);
            } else {
                $this->setBrowser($this->BROWSER_NOKIA);
            }
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Palemoon or not
     * @return boolean True if the browser is Palemoon otherwise false
     */
    protected function checkBrowserPalemoon()
    {
        if (stripos($this->_agent, 'safari') === false) {
            if (preg_match("/Palemoon[\/ \(]([^ ;\)]+)/i", $this->_agent, $matches)) {
                $this->setVersion($matches[1]);
                $this->setBrowser($this->BROWSER_PALEMOON);
                return true;
            } else if (preg_match("/Palemoon([0-9a-zA-Z\.]+)/i", $this->_agent, $matches)) {
                $this->setVersion($matches[1]);
                $this->setBrowser($this->BROWSER_PALEMOON);
                return true;
            } else if (preg_match("/Palemoon/i", $this->_agent, $matches)) {
                $this->setVersion('');
                $this->setBrowser($this->BROWSER_PALEMOON);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is UCBrowser or not
     * @return boolean True if the browser is UCBrowser otherwise false
     */
    protected function checkBrowserUCBrowser()
    {
        if (preg_match('/UC ?Browser\/?([\d\.]+)/', $this->_agent, $matches)) {
            if (isset($matches[1])) {
                $this->setVersion($matches[1]);
            }
            if (stripos($this->_agent, 'Mobile') !== false) {
                $this->setMobile(true);
            } else {
                $this->setTablet(true);
            }
            $this->setBrowser($this->BROWSER_UCBROWSER);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Firefox or not
     * @return boolean True if the browser is Firefox otherwise false
     */
    protected function checkBrowserFirefox()
    {
        if (stripos($this->_agent, 'safari') === false) {
            if (preg_match("/Firefox[\/ \(]([^ ;\)]+)/i", $this->_agent, $matches)) {
                $this->setVersion($matches[1]);
                $this->setBrowser($this->BROWSER_FIREFOX);
                //Firefox on Android
                if (stripos($this->_agent, 'Android') !== false || stripos($this->_agent, 'iPhone') !== false) {
                    if (stripos($this->_agent, 'Mobile') !== false || stripos($this->_agent, 'Tablet') !== false) {
                        $this->setMobile(true);
                    } else {
                        $this->setTablet(true);
                    }
                }
                return true;
            } else if (preg_match("/Firefox([0-9a-zA-Z\.]+)/i", $this->_agent, $matches)) {
                $this->setVersion($matches[1]);
                $this->setBrowser($this->BROWSER_FIREFOX);
                return true;
            } else if (preg_match("/Firefox$/i", $this->_agent, $matches)) {
                $this->setVersion('');
                $this->setBrowser($this->BROWSER_FIREFOX);
                return true;
            }
        } elseif (preg_match("/FxiOS[\/ \(]([^ ;\)]+)/i", $this->_agent, $matches)) {
            $this->setVersion($matches[1]);
            $this->setBrowser($this->BROWSER_FIREFOX);
            //Firefox on Android
            if (stripos($this->_agent, 'Android') !== false || stripos($this->_agent, 'iPhone') !== false) {
                if (stripos($this->_agent, 'Mobile') !== false || stripos($this->_agent, 'Tablet') !== false) {
                    $this->setMobile(true);
                } else {
                    $this->setTablet(true);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Firefox or not (last updated 1.7)
     * @return boolean True if the browser is Firefox otherwise false
     */
    protected function checkBrowserIceweasel()
    {
        if (stripos($this->_agent, 'Iceweasel') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Iceweasel'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_ICEWEASEL);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Mozilla or not (last updated 1.7)
     * @return boolean True if the browser is Mozilla otherwise false
     */
    protected function checkBrowserMozilla()
    {
        if (stripos($this->_agent, 'mozilla') !== false && preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->_agent) && stripos($this->_agent, 'netscape') === false) {
            $aversion = explode(' ', stristr($this->_agent, 'rv:'));
            preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->_agent, $aversion);
            $this->setVersion(str_replace('rv:', '', $aversion[0]));
            $this->setBrowser($this->BROWSER_MOZILLA);
            return true;
        } else if (stripos($this->_agent, 'mozilla') !== false && preg_match('/rv:[0-9]\.[0-9]/i', $this->_agent) && stripos($this->_agent, 'netscape') === false) {
            $aversion = explode('', stristr($this->_agent, 'rv:'));
            $this->setVersion(str_replace('rv:', '', $aversion[0]));
            $this->setBrowser($this->BROWSER_MOZILLA);
            return true;
        } else if (stripos($this->_agent, 'mozilla') !== false && preg_match('/mozilla\/([^ ]*)/i', $this->_agent, $matches) && stripos($this->_agent, 'netscape') === false) {
            $this->setVersion($matches[1]);
            $this->setBrowser($this->BROWSER_MOZILLA);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Lynx or not (last updated 1.7)
     * @return boolean True if the browser is Lynx otherwise false
     */
    protected function checkBrowserLynx()
    {
        if (stripos($this->_agent, 'lynx') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Lynx'));
            $aversion = explode(' ', (isset($aresult[1]) ? $aresult[1] : ''));
            $this->setVersion($aversion[0]);
            $this->setBrowser($this->BROWSER_LYNX);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Amaya or not (last updated 1.7)
     * @return boolean True if the browser is Amaya otherwise false
     */
    protected function checkBrowserAmaya()
    {
        if (stripos($this->_agent, 'amaya') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Amaya'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_AMAYA);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Safari or not (last updated 1.7)
     * @return boolean True if the browser is Safari otherwise false
     */
    protected function checkBrowserSafari()
    {
        if (
            stripos($this->_agent, 'Safari') !== false
            && stripos($this->_agent, 'iPhone') === false
            && stripos($this->_agent, 'iPod') === false
        ) {

            $aresult = explode('/', stristr($this->_agent, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion($this->VERSION_UNKNOWN);
            }
            $this->setBrowser($this->BROWSER_SAFARI);
            return true;
        }
        return false;
    }

    protected function checkBrowserSamsung()
    {
        if (stripos($this->_agent, 'SamsungBrowser') !== false) {

            $aresult = explode('/', stristr($this->_agent, 'SamsungBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion($this->VERSION_UNKNOWN);
            }
            $this->setBrowser($this->BROWSER_SAMSUNG);
            return true;
        }
        return false;
    }

    protected function checkBrowserSilk()
    {
        if (stripos($this->_agent, 'Silk') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Silk'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion($this->VERSION_UNKNOWN);
            }
            $this->setBrowser($this->BROWSER_SILK);
            return true;
        }
        return false;
    }

    protected function checkBrowserIframely()
    {
        if (stripos($this->_agent, 'Iframely') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Iframely'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion($this->VERSION_UNKNOWN);
            }
            $this->setBrowser($this->BROWSER_I_FRAME);
            return true;
        }
        return false;
    }

    protected function checkBrowserCocoa()
    {
        if (stripos($this->_agent, 'CocoaRestClient') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'CocoaRestClient'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion($this->VERSION_UNKNOWN);
            }
            $this->setBrowser($this->BROWSER_COCOA);
            return true;
        }
        return false;
    }

    /**
     * Detect if URL is loaded from FacebookExternalHit
     * @return boolean True if it detects FacebookExternalHit otherwise false
     */
    protected function checkFacebookExternalHit()
    {
        if (stristr($this->_agent, 'FacebookExternalHit')) {
            $this->setRobot(true);
            $this->setFacebook(true);
            return true;
        }
        return false;
    }

    /**
     * Detect if URL is being loaded from internal Facebook browser
     * @return boolean True if it detects internal Facebook browser otherwise false
     */
    protected function checkForFacebookIos()
    {
        if (stristr($this->_agent, 'FBIOS')) {
            $this->setFacebook(true);
            return true;
        }
        return false;
    }

    /**
     * Detect Version for the Safari browser on iOS devices
     * @return boolean True if it detects the version correctly otherwise false
     */
    protected function getSafariVersionOnIos()
    {
        $aresult = explode('/', stristr($this->_agent, 'Version'));
        if (isset($aresult[1])) {
            $aversion = explode(' ', $aresult[1]);
            $this->setVersion($aversion[0]);
            return true;
        }
        return false;
    }

    /**
     * Detect Version for the Chrome browser on iOS devices
     * @return boolean True if it detects the version correctly otherwise false
     */
    protected function getChromeVersionOnIos()
    {
        $aresult = explode('/', stristr($this->_agent, 'CriOS'));
        if (isset($aresult[1])) {
            $aversion = explode(' ', $aresult[1]);
            $this->setVersion($aversion[0]);
            $this->setBrowser($this->BROWSER_CHROME);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is iPhone or not (last updated 1.7)
     * @return boolean True if the browser is iPhone otherwise false
     */
    protected function checkBrowseriPhone()
    {
        if (stripos($this->_agent, 'iPhone') !== false) {
            $this->setVersion($this->VERSION_UNKNOWN);
            $this->setBrowser($this->BROWSER_IPHONE);
            $this->getSafariVersionOnIos();
            $this->getChromeVersionOnIos();
            $this->checkForFacebookIos();
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is iPad or not (last updated 1.7)
     * @return boolean True if the browser is iPad otherwise false
     */
    protected function checkBrowseriPad()
    {
        if (stripos($this->_agent, 'iPad') !== false) {
            $this->setVersion($this->VERSION_UNKNOWN);
            $this->setBrowser($this->BROWSER_IPAD);
            $this->getSafariVersionOnIos();
            $this->getChromeVersionOnIos();
            $this->checkForFacebookIos();
            $this->setTablet(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is iPod or not (last updated 1.7)
     * @return boolean True if the browser is iPod otherwise false
     */
    protected function checkBrowseriPod()
    {
        if (stripos($this->_agent, 'iPod') !== false) {
            $this->setVersion($this->VERSION_UNKNOWN);
            $this->setBrowser($this->BROWSER_IPOD);
            $this->getSafariVersionOnIos();
            $this->getChromeVersionOnIos();
            $this->checkForFacebookIos();
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Android or not (last updated 1.7)
     * @return boolean True if the browser is Android otherwise false
     */
    protected function checkBrowserAndroid()
    {
        if (stripos($this->_agent, 'Android') !== false) {
            $aresult = explode(' ', stristr($this->_agent, 'Android'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion($this->VERSION_UNKNOWN);
            }
            if (stripos($this->_agent, 'Mobile') !== false) {
                $this->setMobile(true);
            } else {
                $this->setTablet(true);
            }
            $this->setBrowser($this->BROWSER_ANDROID);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Vivaldi
     * @return boolean True if the browser is Vivaldi otherwise false
     */
    protected function checkBrowserVivaldi()
    {
        if (stripos($this->_agent, 'Vivaldi') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'Vivaldi'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_VIVALDI);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Yandex
     * @return boolean True if the browser is Yandex otherwise false
     */
    protected function checkBrowserYandex()
    {
        if (stripos($this->_agent, 'YaBrowser') !== false) {
            $aresult = explode('/', stristr($this->_agent, 'YaBrowser'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_YANDEX);

                if (stripos($this->_agent, 'iPad') !== false) {
                    $this->setTablet(true);
                } elseif (stripos($this->_agent, 'Mobile') !== false) {
                    $this->setMobile(true);
                } elseif (stripos($this->_agent, 'Android') !== false) {
                    $this->setTablet(true);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the browser is a PlayStation
     * @return boolean True if the browser is PlayStation otherwise false
     */
    protected function checkBrowserPlayStation()
    {
        if (stripos($this->_agent, 'PlayStation ') !== false) {
            $aresult = explode(' ', stristr($this->_agent, 'PlayStation '));
            $this->setBrowser($this->BROWSER_PLAYSTATION);
            if (isset($aresult[0])) {
                $aversion = explode(')', $aresult[2]);
                $this->setVersion($aversion[0]);
                if (stripos($this->_agent, 'Portable)') !== false || stripos($this->_agent, 'Vita') !== false) {
                    $this->setMobile(true);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Wget or not (last updated 1.7)
     * @return boolean True if the browser is Wget otherwise false
     */
    protected function checkBrowserWget()
    {
        if (preg_match("!^Wget/([^ ]+)!i", $this->_agent, $aresult)) {
            $this->setVersion($aresult[1]);
            $this->setBrowser($this->BROWSER_WGET);
            return true;
        }
        return false;
    }
    /**
     * Determine if the browser is cURL or not (last updated 1.7)
     * @return boolean True if the browser is cURL otherwise false
     */
    protected function checkBrowserCurl()
    {
        if (strpos($this->_agent, 'curl') === 0) {
            $aresult = explode('/', stristr($this->_agent, 'curl'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser($this->BROWSER_CURL);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine the user's platform (last updated 2.0)
     */
    protected function checkPlatform()
    {
        if (stripos($this->_agent, 'windows') !== false) {
            $this->_platform = $this->PLATFORM_WINDOWS;
        } else if (stripos($this->_agent, 'iPad') !== false) {
            $this->_platform = $this->PLATFORM_IPAD;
        } else if (stripos($this->_agent, 'iPod') !== false) {
            $this->_platform = $this->PLATFORM_IPOD;
        } else if (stripos($this->_agent, 'iPhone') !== false) {
            $this->_platform = $this->PLATFORM_IPHONE;
        } elseif (stripos($this->_agent, 'mac') !== false) {
            $this->_platform = $this->PLATFORM_APPLE;
        } elseif (stripos($this->_agent, 'android') !== false) {
            $this->_platform = $this->PLATFORM_ANDROID;
        } elseif (stripos($this->_agent, 'Silk') !== false) {
            $this->_platform = $this->PLATFORM_FIRE_OS;
        } elseif (stripos($this->_agent, 'linux') !== false && stripos($this->_agent, 'SMART-TV') !== false) {
            $this->_platform = $this->PLATFORM_LINUX . '/' . $this->PLATFORM_SMART_TV;
        } elseif (stripos($this->_agent, 'linux') !== false) {
            $this->_platform = $this->PLATFORM_LINUX;
        } else if (stripos($this->_agent, 'Nokia') !== false) {
            $this->_platform = $this->PLATFORM_NOKIA;
        } else if (stripos($this->_agent, 'BlackBerry') !== false) {
            $this->_platform = $this->PLATFORM_BLACKBERRY;
        } elseif (stripos($this->_agent, 'FreeBSD') !== false) {
            $this->_platform = $this->PLATFORM_FREEBSD;
        } elseif (stripos($this->_agent, 'OpenBSD') !== false) {
            $this->_platform = $this->PLATFORM_OPENBSD;
        } elseif (stripos($this->_agent, 'NetBSD') !== false) {
            $this->_platform = $this->PLATFORM_NETBSD;
        } elseif (stripos($this->_agent, 'OpenSolaris') !== false) {
            $this->_platform = $this->PLATFORM_OPENSOLARIS;
        } elseif (stripos($this->_agent, 'SunOS') !== false) {
            $this->_platform = $this->PLATFORM_SUNOS;
        } elseif (stripos($this->_agent, 'OS\/2') !== false) {
            $this->_platform = $this->PLATFORM_OS2;
        } elseif (stripos($this->_agent, 'BeOS') !== false) {
            $this->_platform = $this->PLATFORM_BEOS;
        } elseif (stripos($this->_agent, 'win') !== false) {
            $this->_platform = $this->PLATFORM_WINDOWS;
        } elseif (stripos($this->_agent, 'Playstation') !== false) {
            $this->_platform = $this->PLATFORM_PLAYSTATION;
        } elseif (stripos($this->_agent, 'Roku') !== false) {
            $this->_platform = $this->PLATFORM_ROKU;
        } elseif (stripos($this->_agent, 'iOS') !== false) {
            $this->_platform = $this->PLATFORM_IPHONE . '/' . $this->PLATFORM_IPAD;
        } elseif (stripos($this->_agent, 'tvOS') !== false) {
            $this->_platform = $this->PLATFORM_APPLE_TV;
        } elseif (stripos($this->_agent, 'curl') !== false) {
            $this->_platform = $this->PLATFORM_TERMINAL;
        } elseif (stripos($this->_agent, 'CrOS') !== false) {
            $this->_platform = $this->PLATFORM_CHROME_OS;
        } elseif (stripos($this->_agent, 'okhttp') !== false) {
            $this->_platform = $this->PLATFORM_JAVA_ANDROID;
        } elseif (stripos($this->_agent, 'PostmanRuntime') !== false) {
            $this->_platform = $this->PLATFORM_POSTMAN;
        } elseif (stripos($this->_agent, 'Iframely') !== false) {
            $this->_platform = $this->PLATFORM_I_FRAME;
        }
    }

    /**
     * Determine user's OS
     */

    protected function checkSystemInfo()
    {
        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $this->_agent))
                $this->setPlatform($value);
    }

    /**
     * Get users IP
     */

    protected function getClientIp()
    {
        return $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                getenv('HTTP_FORWARDED_FOR')?:
                getenv('HTTP_FORWARDED')?:
                getenv('REMOTE_ADDR');
    }
}
