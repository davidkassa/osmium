<?php
/* Osmium
 * Copyright (C) 2012, 2013 Romain "Artefact2" Dalmaso <artefact2@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Osmium;

if(!defined('Osmium\ROOT')) {
	require __DIR__.'/dispatchroot.php';
}

/** Bump this when static files (icons, etc.) are updated */
const STATICVER = 12;

/** Bump this when CSS files are updated */
const CSS_STATICVER = 16;

/** Bump this when JS snippets are updated */
const JS_STATICVER = 19;

/** Bump this when clientdata.json is updated */
const CLIENT_DATA_STATICVER = 26;

define(__NAMESPACE__.'\CACHE_DIRECTORY', ROOT.'/cache');

define(__NAMESPACE__.'\HOST',
       isset($_SERVER['HTTP_HOST']) ? explode(':', $_SERVER['HTTP_HOST'], 2)[0] : 'local'
);

if(!is_dir(CACHE_DIRECTORY) || !is_writeable(CACHE_DIRECTORY)) {
	fatal(500, "Cache directory '".CACHE_DIRECTORY."' is not writeable.");
}

if(isset($_SERVER['REMOTE_ADDR'])) {
	session_set_cookie_params(0, get_ini_setting('relative_path'), HOST, HTTPS, true);
	session_save_path(CACHE_DIRECTORY);
	session_name("SID");
	session_start();
}

require ROOT.'/inc/chrome.php';
require ROOT.'/inc/forms.php';
require ROOT.'/inc/db.php';
require ROOT.'/inc/eveapi.php';
require ROOT.'/inc/state.php';
require ROOT.'/inc/fit.php';
require ROOT.'/inc/dogma.php';
require ROOT.'/inc/flag.php';
require ROOT.'/inc/search.php';
require ROOT.'/inc/log.php';
require ROOT.'/inc/notification.php';
require ROOT.'/inc/reputation.php';

\Osmium\Forms\post_redirect_get();

if(!\Osmium\State\is_logged_in()) {
	\Osmium\State\try_recover();
}
