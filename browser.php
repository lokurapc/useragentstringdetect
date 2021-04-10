<?php
/*****************************************************************

	File name: browser.php
	Author: Gary White
	Last modified: November 10, 2003
	Author: Reza Moallemi
	Last modified: April 27, 2011
	Author: lokurapc
	Last modified: April 27, 2019

	**************************************************************

	Copyright (C) 2003  Gary White
	Copyright (C) 2011  Reza Moallemi
	Copyright (C) 2019  lokurapc

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details at:
	http://www.gnu.org/copyleft/gpl.html

	**************************************************************

	Browzer class

	Identifies the user's Operating system, browser and version
	by parsing the HTTP_USER_AGENT string sent to the server

	Typical Usage:

		require_once($_SERVER['DOCUMENT_ROOT'].'/include/browser.php');
		$br = new Browzer;
		echo "$br->Platform, $br->Name version $br->Version";

	For operating systems, it will correctly identify:
		Android
		Bada
		BeOS
		BlackBerry
		CentOS
		ChromeOS
		Chromecast
		Darwin
		Debian
		Fedora
		FreeBSD
		iOS (iPad/iPod/iPhone)
		Gentoo
		Java
		Linux
		Linux-mint
		MacOS (Macintosh)
		Mandriva
		Microsoft Windows
		NetBSD
		OS/2
		OpenBSD
		RedHat
		SUSE
		Slackware
		Solaris (SunOS)
		Symbian
		Tizen
		Ubuntu
		Unix
		Windows Phone
		Zenwalk

	Anything not determined to be one of the above is considered to by Unix
	because most Unix based browsers seem to not report the operating system.
	The only known problem here is that, if a HTTP_USER_AGENT string does not
	contain the operating system, it will be identified as Unix. For unknown
	browsers, this may not be correct.

	For browsers, it should correctly identify all versions of:
		AOL
		Amaya
		Arora
		Avant
		CM Browser
		Camino
		Chrome
		Chromium
		Comodo Dragon
		Dillo
		Dolfin
		Edge
		Epiphany
		Falkon
		Fennec
		Firebird
		Firefox
		Flock
		Galeon
		iCab
		IceCat
		IceDragon
		Iceape
		Iceweasel
		Internet Explorer
		Iridium
		K-Meleon
		Kazehakase
		Konqueror
		Links
		Lobo
		Lunascape
		Lynx
		Maxthon
		Midori
		Minefield
		Mozilla
		NetFront
		NetSurf
		Netscape
		NokiaBrowser
		OmniWeb
		Opera
		Orca
		OviBrowser
		PaleMoon
		Phoenix
		Pocket Internet Explorer for handhelds
		Puffin
		QQBrowser
		QupZilla
		Safari
		SamsungBrowser
		SeaMonkey
		Shiira
		Shiretoko
		Silk
		Sleipnir
		SlimBoat
		SongBird
		SrwareIron
		Sunrise
		UCBrowser
		Vivaldi
		Waterfox
		w3m
		Wyzo
		YaBrowser
*****************************************************************/

	class Browser {

		public $Name = "Unknown";
		public $Version = "";
		public $Platform = "Unknown";
		public $Pver = "";
		public $Agent = "Not reported";
		public $Image = "";
		public $Architecture = "";

		public function __construct($agent) {

			// initialize properties
			$bd['platform'] = "Unknown";
			$bd['pver'] = "";
			$bd['browser']="Unknown";
			$bd['version']="";
			$bd['architecture'] = "";
			$this->Agent = $agent;

			// first find operating system

			if (stripos($agent,'win')) {  //Windows
				$bd['platform'] = 'Windows';
				if (stripos($agent,'NT 10.0')) {
					$val = '10';
				} elseif (stripos($agent,'NT 6.3')) {
					$val = '8.1';
				} elseif (stripos($agent,'NT 6.2')) {
					$val = '8';
				} elseif (stripos($agent,'NT 6.1')) {
					$val = '7';
				} elseif (stripos($agent,'NT 6.0')) {
					$val = 'Vista';
				} elseif (stripos($agent,'NT 5.2')) {
					$val = 'XP 64-bit/Server 2003';
				} elseif (stripos($agent,'NT 5.1')) {
					$val = 'XP';
				} elseif (stripos($agent,'NT 5.01')) {
					$val = '2000 SP1';
				} elseif (stripos($agent,'NT 5.0')) {
					$val = '2000';
				} elseif (stripos($agent,'NT 4.0')) {
					$val = 'NT 4.0';
				} elseif (stripos($agent,'Win 9x 4.90')) {
					$val = 'Millennium';
				} elseif (stripos($agent,'98')) {
					$val = '98';
				} elseif (stripos($agent,'95')) {
					$val = '95';
				} else {
					$val = '';
				}
				$bd['pver'] = $val;
			}
			if (stripos($agent,'Windows Phone')) { //test for Windows Phone
				$bd['platform'] = 'Windows Phone';
				$bd['pver'] = '';
			} elseif (stripos($agent,'Microsoft Windows')) {
				$bd['platform'] = 'Windows';
				$bd['pver'] = '';

			} elseif (preg_match('/iPad/i', $agent)) {
				$bd['browser'] = 'Safari';
				$bd['platform'] = 'iPad';
				if (preg_match('/CPU\ OS\ ([._0-9a-zA-Z]+)/i', $agent, $regmatch)) {
					$bd['pver'] = " iOS ".str_replace("_", ".", $regmatch[1]);
				}
			} elseif (preg_match('/iPod/i', $agent)) {
				$bd['browser'] = 'Safari';
				$bd['platform'] = 'iPod';
				if (preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i', $agent, $regmatch)) {
					$bd['pver'] = " iOS ".str_replace("_", ".", $regmatch[1]);
				}
			} elseif (preg_match('/iPhone/i', $agent)) {
				$bd['browser'] = 'Safari';
				$bd['platform'] = 'iPhone';
				if (preg_match('/iPhone\ OS\ ([._0-9a-zA-Z]+)/i', $agent, $regmatch)) {
					$bd['pver'] = " iOS ".str_replace("_", ".", $regmatch[1]);
				}

			} elseif (stristr($agent,'BlackBerry')) {
				$bd['platform'] = 'BlackBerry';
			} elseif (stripos($agent,'BB10')) {
				$bd['platform'] = 'BlackBerry';
			} elseif (stripos($agent,'Fedora')) {
				$bd['platform'] = 'Fedora ';
			} elseif (stripos($agent,'Debian')) {
				$bd['platform'] = 'Debian';
			} elseif (stripos($agent,'Ubuntu')) {
				$bd['platform'] = 'Ubuntu';
			} elseif (stripos($agent,'Gentoo')) {
				$bd['platform'] = 'Gentoo';
			} elseif (stripos($agent,'Centos')) {
				$bd['platform'] = 'CentOS';
			} elseif (stripos($agent,'Slackware')) {
				$bd['platform'] = 'Slackware';
			} elseif (stripos($agent,'SUSE')) {
				$bd['platform'] = 'SUSE';
			} elseif (stripos($agent,'Mandriva')) {
				$bd['platform'] = 'Mandriva';
			} elseif (stripos($agent,'Red Hat')) {
				$bd['platform'] = 'RedHat';
			} elseif (stripos($agent,'Zenwalk')) {
				$bd['platform'] = 'Zenwalk';
			} elseif (stripos($agent,'Tizen')) {
				$bd['platform'] = 'Tizen';
			} elseif (stripos($agent,'CrKey')) {
				$bd['platform'] = 'Chromecast';
			} elseif (stripos($agent,'Android')) {
				$bd['platform'] = 'Android';
			} elseif (stripos($agent,'Linux mint')) {
				$bd['platform'] = 'Linux mint';
			} elseif (stripos($agent,'Linux')) {
				$bd['platform'] = 'Linux';
			} elseif (stripos($agent,'mac os')) {
				$bd['platform'] = 'MacIntosh';
			} elseif (stripos($agent,'Macintosh')) {
				$bd['platform'] = 'Macintosh';
			} elseif (stripos($agent,'OS/2')) {
				$bd['platform'] = "OS2";
			} elseif (stripos($agent,'Symbian')) {
				$bd['platform'] = "Symbian";
			} elseif (stripos($agent,'SymbOS')) {
				$bd['platform'] = "Symbian";
			} elseif (stripos($agent,'BeOS')) {
				$bd['platform'] = "BeOS";
			} elseif (stripos($agent,'FreeBSD')) {
				$bd['platform'] = 'FreeBSD';
			} elseif (stripos($agent,'OpenBSD')) {
				$bd['platform'] = 'OpenBSD';
			} elseif (stripos($agent,'NetBSD')) {
				$bd['platform'] = 'NetBSD';
			} elseif (stripos($agent,'CrOS') && !stripos($agent,'microsoft')) {
				$bd['platform'] = 'ChromeOS';
			} elseif (stripos($agent,'Darwin')) {
				$bd['platform'] = 'Darwin';
			} elseif (stripos($agent,'SunOS')) {
				$bd['platform'] = 'Solaris';
			} elseif (stripos($agent,'Bada')) {
				$bd['platform'] = 'Bada';
			} elseif (stripos($agent,'Unix')) {
				$bd['platform'] = 'Unix';
			} elseif (stripos($agent,'j2me')) {
				$bd['platform'] = 'Java';
			}

			//now find browser name

			if (stristr($agent,'opera')) { // test for Opera
				if (stristr($agent,'opera mini')) { // test for Opera Mini
					$bd['browser'] = 'Opera Mini';
					$val = explode("/",stristr($agent,"Opera Mini"));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				} elseif (stristr($agent,'opera mobi')) { // test for Opera Mobi
					$bd['browser'] = 'Opera Mobi';
					$val = explode("/",stristr($agent,"Opera Mobi"));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				} else {
					if (stripos($agent,'version/1')) { // test for Opera > 9
						$bd['browser'] = 'Opera';
						$val = stristr($agent,"version/1");
						$val = explode("/",$val);
						$bd['version'] = $val[1];
					} elseif (stripos($agent,'opera/')) {
						$bd['browser'] = 'Opera';
						$val = explode("/",stristr($agent,'opera'));
						$val = explode(" ",$val[1]);
						$bd['version'] = $val[0];
					} else {
						$bd['browser'] = 'Opera';
						$val = explode(" ",stristr($agent,'opera'));
						$bd['version'] = $val[1];
					}
				}
			} elseif (stripos($agent,'OPR')) { // new version of Opera
				$bd['browser'] = 'Opera';
				$val = explode("/",stristr($agent,"OPR"));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'k-meleon')) { // test for K-Meleon
				$bd['browser'] = 'K-Meleon';
				$val = explode('K-Meleon',$agent);
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'shiira')) { // test for Shiira
				$bd['browser'] = 'Shiira';
				$val = explode('Shiira',$agent);
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'galeon')) { // test for Galeon
				$bd['browser'] = 'Galeon';
				$val = explode('Galeon',$agent);
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'epiphany')) { // test for Epiphany
				$bd['browser'] = 'Epiphany';
				$val = explode('Epiphany',$agent);
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'camino')) { // test for Camino
				$bd['browser'] = 'Camino';
				$val = explode('Camino',$agent);
				$val = explode(' ',$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'avant')) { // test for Avant
				$bd['browser'] = 'Avant';
				$bd['version'] = 'Browser';
			} elseif (stripos($agent,'maxthon')) { // test for Maxthon
				if (stripos($agent,'maxthon/')) {
					$bd['browser']="Maxthon";
					$val = explode("/",stristr($agent,'maxthon'));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				} else {
					$bd['browser']="Maxthon";
					$val = explode(" ",stristr($agent,'maxthon'));
					$bd['version'] = $val[1];
				}
			} elseif (stripos($agent,'Flock')) { // test  for Flock
				$bd['browser'] = 'Flock';
				$val = explode("/",stristr($agent,"Flock"));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'konqueror')) { // test for Konqueror
				$bd['browser'] = 'Konqueror';
				if (stripos($agent,'Konqueror/')) {
					$val = explode("/",stristr($agent,'Konqueror'));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				}
			} elseif (stripos($agent,'lunascape')) { //test for Lunascape
				$bd['browser'] = 'Lunascape';
			} elseif (stripos($agent,'orca')) { // test for Orca
				$bd['browser'] = 'Orca';
			} elseif (stripos($agent,'Dolfin')) { // test for Dolfin
				$bd['browser'] = 'Dolfin';
				$val = explode("/",stristr($agent,"Dolfin"));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'NetPositive')) { // test for NetPositive
				$bd['browser'] = 'NetPositive';
				$val = explode("/",stristr($agent,"NetPositive"));
				$bd['platform'] = "BeOS";
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Lobo')) { // test for Lobo
				$bd['browser']="Lobo";
				$val = explode("/",stristr($agent,"Lobo"));
				$bd['version'] = $val[1];

			// test for MS Internet Explorer version 1
			} elseif (stripos($agent,'microsoft internet explorer')) {
				$bd['browser'] = 'IE';
				$bd['version'] = '1.0';
				$var = stristr($agent, "/");
				if (ereg("308|425|426|474|0b1", $var)) {
					$bd['version']="1.5";
				}

			// test for MS Internet Explorer
			} elseif (stripos($agent,'msie') && !stripos($agent,'opera')) {
				$val = explode(" ",stristr($agent,"msie"));
				$bd['browser'] = 'MSIE';
				$bd['version'] = $val[1];

			// text for MS Internet Explorer version 11
			} elseif (stripos($agent,'trident')) {
				$val = explode("/",stristr($agent,'trident'));
				if ($val[1] == 7){
				$bd['browser'] = 'MSIE';
				$bd['version'] = '11.0';
				}

			// test for Edge
			} elseif (stripos($agent,'edge')) {
				$val = explode("/",stristr($agent,'edge'));
				$bd['browser'] = 'Edge';
				$bd['version'] = $val[1];

			// test for MS Pocket Internet Explorer
			} elseif (stripos($agent,'mspie') || stripos($agent,'pocket')) {
				$val = explode(" ",stristr($agent,'mspie'));
				$bd['browser'] = 'MSPIE';
				$bd['platform'] = 'WindowsCE';
				if (stripos($agent,'mspie')) {
					$bd['version'] = $val[1];
				} else {
					$val = explode('/',$agent);
					$bd['version'] = $val[1];
				}

			} elseif (stripos($agent,'Konqueror')) { // test for Konqueror
				$bd['browser'] = 'Konqueror';
				$val = explode(" ",stristr($agent,'Konqueror'));
				$val = explode("/",$val[0]);
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'icab')) { // test for iCab
				if (stripos($agent,'icab/')) {
					$bd['browser']="iCab";
					$val = explode("/",stristr($agent,'icab'));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				} else {
					$bd['browser']="iCab";
					$val = explode(" ",stristr($agent,'icab'));
					$bd['version'] = $val[1];
				}
			} elseif (stripos($agent,'omniweb')) { // test for OmniWeb
				$bd['browser'] = 'OmniWeb';
				$val = explode("/",stristr($agent,'omniweb'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'UCBrowser')) { // test for UCBrowser
				$bd['browser'] = 'UCBrowser';
				$val = explode("/",stristr($agent,'UCBrowser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'UC Browser')) { // test for UCBrowser
				$bd['browser'] = 'UCBrowser';
				$val = explode("/",stristr($agent,'UC Browser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'UBrowser')) { // test for UCBrowser
				$bd['browser'] = 'UCBrowser';
				$val = explode("/",stristr($agent,'UBrowser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Puffin')) { // test for Puffin
				$bd['browser'] = 'Puffin';
				$val = explode("/",stristr($agent,'Puffin'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'YaBrowser')) { // test for YaBrowser
				$bd['browser'] = 'YaBrowser';
				$val = explode("/",stristr($agent,'YaBrowser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'PaleMoon')) { // test for PaleMoon
				$bd['browser'] = 'PaleMoon';
				$val = explode("/",stristr($agent,'PaleMoon'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Silk')) { // test for Silk (Amazon)
				$bd['browser'] = 'Silk';
				$val = explode("/",stristr($agent,'Silk'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Vivaldi')) { // test for Vivaldi
				$bd['browser'] = 'Vivaldi';
				$val = explode("/",stristr($agent,'Vivaldi'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'QQBrowser')) { // test for QQBrowser
				$bd['browser'] = 'QQBrowser';
				$val = explode("/",stristr($agent,'QQBrowser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Iron')) { // test for SrwareIron
				$bd['browser'] = 'SrwareIron';
				$val = explode("/",stristr($agent,'Iron'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Midori')) { // test for Midori
				$bd['browser'] = 'Midori';
				$val = explode("/",stristr($agent,'Midori'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Sleipnir')) { // test for Sleipnir
				$bd['browser'] = 'Sleipnir';
				$val = explode("/",stristr($agent,'Sleipnir'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'SlimBoat')) { // test for SlimBoat
				$bd['browser'] = 'SlimBoat';
				$val = explode("/",stristr($agent,'SlimBoat'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'AOL')) { // test for AOL
				$bd['browser'] = 'AOL';
				$val = explode("/",stristr($agent,'AOL'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'SamsungBrowser')) { // test for SamsungBrowser
				$bd['browser'] = 'SamsungBrowser';
				$val = explode("/",stristr($agent,'SamsungBrowser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'QupZilla')) { // test for QupZilla
				$bd['browser'] = 'QupZilla';
				$val = explode("/",stristr($agent,'QupZilla'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Falkon')) { // test for Falkon
				$bd['browser'] = 'Falkon';
				$val = explode("/",stristr($agent,'Falkon'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'ACHEETAHI')) { // test for CM Browser
				$bd['browser'] = 'CM Browser';
			} elseif (stripos($agent,'IceDragon')) { // test for Comodo Ice Comodo Dragon
				$bd['browser'] = 'IceDragon';
				$val = explode("/",stristr($agent,'IceDragon'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Dragon')) { // test for Comodo Dragon
				$bd['browser'] = 'Dragon';
				$val = explode("/",stristr($agent,'Dragon'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Iridium')) { // test for Iridium
				$bd['browser'] = 'Iridium';
				$val = explode("/",stristr($agent,'Iridium'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'chromium')) { // test for Chromium
				$bd['browser'] = 'Chromium';
				$val = explode('Chromium',$agent);
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'chrome')) { // test for Chrome
				$bd['browser'] = 'Chrome';
				$val = explode('Chrome',$agent);
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Phoenix')) { // test for Phoenix
				$bd['browser'] = 'Phoenix';
				$val = explode("/",stristr($agent,'Phoenix/'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'netscape')) { // test for Netscape
				$bd['browser'] = 'Netscape';
				$val = explode(" ",stristr($agent,'netscape'));
				$val = explode("/",$val[0]);
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'navigator')) { // test for Netscape Navigator
				$bd['browser'] = 'Netscape';
				$val = explode(" ",stristr($agent,'navigator'));
				$val = explode("/",$val[0]);
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'icecat')) { // test for IceCat
				$bd['browser'] = 'IceCat';
				$val = explode('IceCat',$agent);
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'firebird')) { // test for Firebird
				$bd['browser'] = 'Firebird';
				$val = explode("/",stristr($agent,'Firebird'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'seamonkey')) { // test for SeaMonkey
				$bd['browser'] = 'SeaMonkey';
				$val = explode("/",stristr($agent,'SeaMonkey'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Fennec')) { // test for Fennec
				$bd['browser'] = 'Fennec';
				$val = explode("/",stristr($agent,'Fennec'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Iceweasel')) { // test for Iceweasel
				$bd['browser'] = 'Iceweasel';
				$val = explode("/",stristr($agent,'Iceweasel'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Kazehakase')) { // test for Kazehakase
				$bd['browser'] = 'Kazehakase';
				$val = explode("/",stristr($agent,'Kazehakase'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Wyzo')) { // test for Wyzo
				$bd['browser'] = 'Wyzo';
				$val = explode("/",stristr($agent,'Wyzo'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Waterfox')) { // test for Waterfox
				$bd['browser'] = 'Waterfox';
				$val = explode("/",stristr($agent,'Waterfox'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Firefox')) { // test for Firefox
				$bd['browser'] = 'Firefox';
				$val = explode("/",stristr($agent,'Firefox'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Arora')) { // test for Arora
				$bd['browser'] = 'Arora';
				$val = explode("/",stristr($agent,'Arora'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'NetFront')) { // test for NetFront
				$bd['browser'] = 'NetFront';
				$val = explode("/",stristr($agent,'NetFront'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Iceape')) { // test for Iceape
				$bd['browser'] = 'Iceape';
				$val = explode("/",stristr($agent,'Iceape'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Shiretoko')) { // test for Shiretoko
				$bd['browser'] = 'Shiretoko';
				$val = explode("/",stristr($agent,'Shiretoko'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'Minefield')) { // test for Minefield
				$bd['browser'] = 'Minefield';
				$val = explode("/",stristr($agent,'Minefield'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'OviBrowser')) { // test for OviBrowser
				$bd['platform'] = 'Symbian';
				$bd['browser'] = 'OviBrowser';
				$val = explode("/",stristr($agent,'OviBrowser'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'NetSurf')) { // test for NetSurf
				$bd['browser'] = 'NetSurf';
				$val = explode("/",stristr($agent,'NetSurf'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'SongBird')) { // test for SongBird
				$bd['browser'] = 'SongBird';
				$val = explode("/",stristr($agent,'SongBird'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'Sunrise')) { // test for Sunrise
				$bd['browser'] = 'Sunrise';
				$val = explode("/",stristr($agent,'Sunrise'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'NokiaBrowser')) { // test for NokiaBrowser
				$bd['browser'] = 'NokiaBrowser';
				$val = explode("/",stristr($agent,'NokiaBrowser'));
				$val = explode(" ",$val[1]);
				$bd['version'] = $val[0];
			} elseif (stripos($agent,'safari') && stripos($agent,'version')) { // test for Safari
				if ($bd['platform'] == 'Android'){
					$bd['browser'] = 'WebKit';
				} else {
					$bd['browser'] = 'Safari';
					$val = explode("/",stristr($agent,'version'));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				}
			} elseif (stristr($agent,'mozilla') && stripos($agent,'rv:')) { //test for Mozilla
				$bd['browser'] = 'Mozilla';
				$val = explode(" ",stristr($agent,"rv:"));
				$val = explode(" ",$val[0]);
				$bd['version'] = str_replace("rv:","",$val[0]);
			} elseif (stristr($agent,'Dillo')) { // test for Dillo
				$bd['browser'] = 'Dillo';
			} elseif (stristr($agent,'Links')) { // test for Links
				$bd['browser'] = 'Links';
			} elseif (stristr($agent,'w3m')) { // test for w3m
				$bd['browser'] = 'w3m';
				$val = explode("/",stristr($agent,'w3m'));
				$bd['version'] = $val[1];
			} elseif (stripos($agent,'libwww')) { // test for Lynx & Amaya
				if (stristr($agent,'amaya')) {
					$bd['browser'] = 'Amaya';
					$val = explode("/",stristr($agent,'amaya'));
					$val = explode(" ",$val[1]);
					$bd['version'] = $val[0];
				} else {
					$val = explode('/',$agent);
					$bd['browser'] = 'Lynx';
					$bd['version'] = $val[1];
				}
			}

			if (stripos($agent,'x86_64')) {
				$bd['architecture'] = "Running on a 64 bit processor (INTEL)";
			} elseif (stripos($agent,'amd64')) {
				$bd['architecture'] = "A 64-bit version of your browser is running on a 64-bit processor (AMD)";
			} elseif (stripos($agent,'Win64')) {
				$bd['architecture'] = "A 64-bit version of your browser is running on a 64-bit processor";
			} elseif (stripos($agent,'WOW64')) {
				$bd['architecture'] = "A 32-bit version of your browser is running on a 64-bit processor.";
			}
			if (stripos($agent,'mobile')) {
				$bd['architecture'] = 'Es posible que usted este usando un dispositivo mobil - celular.';
			}
			if (stripos($agent,'smart-tv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV.';
			} elseif (stripos($agent,'smarttv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV.';
			} elseif (stripos($agent,'googletv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV (Google).';
			} elseif (stripos($agent,'sonydtv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV (Sony).';
			} elseif (stripos($agent,'webtv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV.';
			} elseif (stripos($agent,'hbbtv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV.';
			} elseif (stripos($agent,'nettv')) {
				$bd['architecture'] = 'Es posible que usted este usando un Smart-TV.';
			}

			// clean up extraneous garbage that may be in the browser name
			$bd['browser'] = preg_replace("/[^a-zA-Z0-9]/", "", $bd['browser']);
			// clean up extraneous garbage that may be in the browser version
			$bd['version'] = preg_replace("/[^a-zA-Z0-9.]/", "", $bd['version']);

			// clean up extraneous garbage that may be in the platform
			$bd['platform'] = preg_replace("/[^a-zA-Z0-9]/", "", $bd['platform']);
			// clean up extraneous garbage that may be in the platform version
			$bd['pver'] = preg_replace("/[^a-zA-Z0-9.]/", "", $bd['pver']);

			// finally assign our properties
			$this->Name = $bd['browser'];
			$this->Version = $bd['version'];
			$this->Platform = $bd['platform'];
			$this->Pver = $bd['pver'];
			$this->Architecture = $bd['architecture'];

			$this->BrowserImage = strtolower($this->Name);
			if ($this->BrowserImage == "msie") {
				$this->BrowserImage .=  '-'.$this->Version;
			}
			$this->PlatformImage = strtolower($this->Platform);

			if ($this->PlatformImage == "linuxmint") {
				$this->PlatformImage = "linux-mint";
			}
			if ($this->PlatformImage == "windowsphone") {
				$this->PlatformImage = "windows-phone";
			}
			if ($this->PlatformImage == "windows" and ($this->Pver == 'Vista' or $this->Pver == '7')) {
				$this->PlatformImage .=  '-'.strtolower($this->Pver);
			}
		}
	}
?>
