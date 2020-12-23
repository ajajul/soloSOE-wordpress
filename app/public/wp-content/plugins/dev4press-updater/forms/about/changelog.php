<?php if (!defined('ABSPATH')) exit; ?>

<div class="d4p-group d4p-group-changelog">
    <h3><?php _e("Version", "dev4press-updater"); ?> 4</h3>
    <div class="d4p-group-inner">
        <h4>Version: 4.3 / november 13 2020</h4>
        <ul>
            <li><strong>edit</strong> minor updates to the plugin update core</li>
        </ul>

        <h4>Version: 4.2 / may 18 2020</h4>
        <ul>
            <li><strong>new</strong> show current Dev4Press promotion on the plugin dashboard</li>
            <li><strong>edit</strong> improved display of update check errors and messages</li>
            <li><strong>edit</strong> message included when trying to check for updates to quickly</li>
            <li><strong>edit</strong> update check throttle increased to 5 minutes</li>
            <li><strong>fix</strong> wrong URL used on the API Key settings panel</li>
            <li><strong>fix</strong> few minor issues with the core classes organization</li>
        </ul>

        <h4>Version: 4.1 / may 7 2020</h4>
        <ul>
            <li><strong>new</strong> support for new plugins</li>
            <li><strong>new</strong> tested with PHP 7.4</li>
            <li><strong>edit</strong> code style improvements</li>
            <li><strong>edit</strong> d4pLib 2.8.8</li>
            <li><strong>fix</strong> several minor styling issues</li>
            <li><strong>fix</strong> minor issue with with the PHP 7.4 deprecations</li>
        </ul>

        <h4>Version: 4.0.5 / april 7 2020</h4>
        <ul>
            <li><strong>new</strong> support for more addons</li>
        </ul>

        <h4>Version: 4.0.4 / october 22 2019</h4>
        <ul>
            <li><strong>new</strong> support for GD Members Directory Pro for bbPress</li>
        </ul>

        <h4>Version: 4.0.3 / september 1 2019</h4>
        <ul>
            <li><strong>new</strong> support for GD Quantum Theme Pro for bbPress</li>
            <li><strong>edit</strong> switched from the CloudFront CDN to S3 for images</li>
            <li><strong>edit</strong> d4pLib 2.7.6</li>
            <li><strong>fix</strong> update for Comments Form Addon was not working correctly</li>
        </ul>

        <h4>Version: 4.0.2 / june 23 2019</h4>
        <ul>
            <li><strong>new</strong> support for GD Mail Queue plugin and it's addons</li>
            <li><strong>edit</strong> d4pLib 2.7.3</li>
        </ul>

        <h4>Version: 4.0.1 / january 12 2019</h4>
        <ul>
            <li><strong>fix</strong> issue with one of the core plugin filters missing data</li>
        </ul>

        <h4>Version: 4.0 / december 30 2018</h4>
        <ul>
            <li><strong>new</strong> plugin dashboard: show notice about unstable updates</li>
            <li><strong>new</strong> plugin dashboard: include the mark of unstable updates</li>
            <li><strong>new</strong> plugin installed list: important notice about unstable updates</li>
            <li><strong>new</strong> plugins panel: important notice about unstable updates</li>
            <li><strong>new</strong> plugin info popup: important notice about unstable updates</li>
            <li><strong>new</strong> plugin info popup: show banner and extra information</li>
            <li><strong>new</strong> using SCSS for the main plugin styling</li>
            <li><strong>new</strong> updated color scheme for the update cards</li>
            <li><strong>new</strong> use versioned cron job name</li>
            <li><strong>new</strong> translation: ja - 日本語 / Japanese</li>
            <li><strong>edit</strong> various styling improvements and tweaks</li>
            <li><strong>edit</strong> d4pLib 2.5.2</li>
            <li><strong>fix</strong> plugin info popup: sometimes shows wrong information</li>
        </ul>
    </div>
</div>

<div class="d4p-group d4p-group-changelog">
    <h3><?php _e("Version", "dev4press-updater"); ?> 3</h3>
    <div class="d4p-group-inner">
        <h4>Version: 3.9 / october 26 2018</h4>
        <ul>
            <li><strong>new</strong> translation to Dutch (nl_NL)</li>
            <li><strong>new</strong> translation to Italian (it_IT)</li>
            <li><strong>edit</strong> updated display of the plugins and addons</li>
            <li><strong>edit</strong> updated display of the purchase panel</li>
            <li><strong>edit</strong> improvements to the strings used for translations</li>
            <li><strong>edit</strong> changed the icons displayed for all plugins and addons</li>
            <li><strong>edit</strong> updated all existing translation</li>
            <li><strong>edit</strong> d4pLib 2.4.2</li>
        </ul>

        <h4>Version: 3.8.3 / september 11 2018</h4>
        <ul>
            <li><strong>new</strong> translation to French (fr_FR)</li>
            <li><strong>new</strong> translation to Spanish (es_ES)</li>
            <li><strong>new</strong> translation to Serbian (sr_RS)</li>
            <li><strong>new</strong> support for GD Power Search Pro for bbPress</li>
            <li><strong>edit</strong> updated translation to German (de_DE)</li>
            <li><strong>edit</strong> d4pLib 2.4</li>
        </ul>

        <h4>Version: 3.8.2 / july 16 2018</h4>
        <ul>
            <li><strong>new</strong> support for new GD Rating System Pro addons</li>
            <li><strong>edit</strong> d4pLib 2.3.4</li>
        </ul>

        <h4>Version: 3.8.1 / june 28 2018</h4>
        <ul>
            <li><strong>new</strong> support for new GD Rating System Pro addons</li>
            <li><strong>edit</strong> d4pLib 2.3.2</li>
        </ul>

        <h4>Version: 3.8 / january 15 2018</h4>
        <ul>
            <li><strong>new</strong> show plugin and addons icons in the WordPress Updates panel</li>
            <li><strong>new</strong> completely redesigned and updated about panel</li>
            <li><strong>new</strong> show admin notices after plugin update or installation</li>
            <li><strong>edit</strong> d4pLib 2.2.4</li>
            <li><strong>fix</strong> xss vulnerability: query string panel was not sanitized</li>
            <li><strong>fix</strong> xss vulnerability: panel variable for some pages was not verified</li>
            <li><strong>fix</strong> several translation strings missing</li>
        </ul>

        <h4>Version: 3.7.3 / august 6 2017</h4>
        <ul>
            <li><strong>new</strong> support for more addons install and update</li>
            <li><strong>edit</strong> deleting the updater response now deletes throttle check too</li>
            <li><strong>edit</strong> remove previous updater response after plugin update</li>
            <li><strong>edit</strong> d4pLib 2.0.5</li>
            <li><strong>fix</strong> updater not working after own updated due to throttle check</li>
        </ul>

        <h4>Version: 3.7 / july 1 2017</h4>
        <ul>
            <li><strong>new</strong> support for more addons install and update</li>
            <li><strong>new</strong> transient key to prevent too many update checks</li>
            <li><strong>edit</strong> various styling improvements and updates</li>
            <li><strong>edit</strong> d4pLib 2.0.3</li>
            <li><strong>fix</strong> various issues with incomplete updater data</li>
        </ul>

        <h4>Version: 3.6 / april 3 2017</h4>
        <ul>
            <li><strong>new</strong> support for more addons install and update</li>
            <li><strong>new</strong> full accessibility for the plugin interface</li>
            <li><strong>edit</strong> updated debug information logged with full debug</li>
            <li><strong>edit</strong> various improvements to the plugin interface</li>
            <li><strong>edit</strong> d4pLib 1.9.2</li>
            <li><strong>fix</strong> problem with the blog news items layout</li>
        </ul>

        <h4>Version: 3.5 / february 14 2017</h4>
        <ul>
            <li><strong>new</strong> support for addons install and update</li>
            <li><strong>edit</strong> styling updates for smaller devices</li>
            <li><strong>edit</strong> updated panels to indicate plugin or addon</li>
            <li><strong>edit</strong> d4pLib 1.8.9</li>
            <li><strong>fix</strong> install panel shows plugins that are installed</li>
            <li><strong>fix</strong> several issues with the responsive styling</li>
        </ul>

        <h4>Version: 3.4.1 / january 1 2017</h4>
        <ul>
            <li><strong>new</strong> updated translation to German language</li>
            <li><strong>edit</strong> d4pLib 1.8.7</li>
            <li><strong>fix</strong> plugin update status not translating</li>
            <li><strong>fix</strong> missing few strings in the POT translation file</li>
        </ul>

        <h4>Version: 3.4 / december 16 2016</h4>
        <ul>
            <li><strong>new</strong> removed support for themes install and update</li>
            <li><strong>new</strong> move availabe updates to top of the plugins list</li>
            <li><strong>edit</strong> various small updates and enhancements</li>
            <li><strong>edit</strong> updated logo image with new color scheme</li>
            <li><strong>edit</strong> d4pLib 1.8.6</li>
        </ul>

        <h4>Version: 3.3.2 / september 6 2016</h4>
        <ul>
            <li><strong>fix</strong> fatal error upon activation in some rare cases</li>
        </ul>

        <h4>Version: 3.3.1 / september 5 2016</h4>
        <ul>
            <li><strong>new</strong> improved sanitation of plugins settings on save</li>
            <li><strong>edit</strong> front page last check date shows local time</li>
            <li><strong>edit</strong> fully tested with new WordPress 4.6</li>
            <li><strong>edit</strong> d4pLib 1.8</li>
        </ul>

        <h4>Version: 3.3 / may 8 2016</h4>
        <ul>
            <li><strong>new</strong> front panel dashboard with additional options</li>
            <li><strong>new</strong> show plugin related post install URL</li>
            <li><strong>edit</strong> improvements to the plugin install panel</li>
            <li><strong>edit</strong> improved layout and styling for news panels</li>
            <li><strong>edit</strong> minor updates to the plugin front information</li>
            <li><strong>edit</strong> d4pLib 1.6.8</li>
            <li><strong>fix</strong> warning with detection of the domain name</li>
            <li><strong>fix</strong> minor styling issues with plugin blocks</li>
        </ul>

        <h4>Version: 3.2 / april 26 2016</h4>
        <ul>
            <li><strong>new</strong> using SVG icon for the admin menu</li>
            <li><strong>edit</strong> improved handling of the post upgrade check</li>
            <li><strong>edit</strong> improved display for plugin and theme cards</li>
            <li><strong>edit</strong> plugin requires WordPress 4.0 or newer</li>
            <li><strong>edit</strong> d4pLib 1.6.6</li>
            <li><strong>fix</strong> problem with declaration of post upgrade filter </li>
            <li><strong>fix</strong> several outdates actions removing update data</li>
            <li><strong>fix</strong> parsing of feed problems on the News panel</li>
        </ul>

        <h4>Version: 3.1.1 / december 28 2015</h4>
        <ul>
            <li><strong>edit</strong> support for GD Rating System Pro plugin</li>
            <li><strong>edit</strong> d4pLib 1.5.5</li>
        </ul>

        <h4>Version: 3.1 / november 20 2015</h4>
        <ul>
            <li><strong>new</strong> check for update button on top of all panels</li>
            <li><strong>edit</strong> several small visual enhancements for plugin panels</li>
            <li><strong>edit</strong> improved layout for higher resolution screens</li>
            <li><strong>edit</strong> improved styling for some elements for WordPress 4.4</li>
            <li><strong>edit</strong> some important loading changes and improvements</li>
            <li><strong>edit</strong> changed the display of the mySQL version information</li>
            <li><strong>edit</strong> removed PHP close tags from end of all PHP files</li>
            <li><strong>edit</strong> compatibility with WordPress 4.4</li>
            <li><strong>edit</strong> d4pLib 1.5.2</li>
            <li><strong>fix</strong> wrong size of the plugin thumbnails</li>
            <li><strong>fix</strong> broken HTML layout on the Install Themes panel</li>
            <li><strong>fix</strong> several wrongs URL's on the purchase panel</li>
        </ul>

        <h4>Version: 3.0.4 / november 12 2015</h4>
        <ul>
            <li><strong>new</strong> WordPress flags set for Network and Private</li>
            <li><strong>edit</strong> support for GD SEO Toolbox Pro plugin</li>
            <li><strong>edit</strong> d4pLib 1.5.1</li>
        </ul>

        <h4>Version: 3.0.3 / october 22 2015</h4>
        <ul>
            <li><strong>edit</strong> on update or install remove all scheduled update checks</li>
            <li><strong>edit</strong> only main site in the multisite network runs update checks</li>
            <li><strong>edit</strong> d4pLib 1.5</li>
            <li><strong>fix</strong> update check scheduled for all sites in the multisite network</li>
            <li><strong>fix</strong> missing few strings in the POT translation file</li>
            <li><strong>fix</strong> update from old 2.x versions brings the error screen on update to 3.0</li>
        </ul>

        <h4>Version: 3.0.2 / july 12 2015</h4>
        <ul>
            <li><strong>fix</strong> mysql version not detected on every server</li>
            <li><strong>fix</strong> last update check time information on front page</li>
            <li><strong>fix</strong> warnings for missing information on purchase panel</li>
        </ul>

        <h4>Version: 3.0.1 / july 10 2015</h4>
        <ul>
            <li><strong>new</strong> translation to German</li>
            <li><strong>edit</strong> updates Dev4Press networks and plugins links</li>
            <li><strong>del</strong> removed outdated translations for 2.x versions</li>
            <li><strong>fix</strong> several strict php notices and warnings</li>
            <li><strong>fix</strong> translation format for the last update 'ago'</li>
            <li><strong>fix</strong> admin menu items names not translatable</li>
            <li><strong>fix</strong> translation page showing wrong information</li>
        </ul>

        <h4>Version: 3.0 / june 30 2015</h4>
        <ul>
            <li><strong>new</strong> plugin is fully rewritten and simpler</li>
            <li><strong>new</strong> deeper integration into WordPress updater</li>
            <li><strong>new</strong> panel for plugins and themes purchase</li>
        </ul>
    </div>
</div>

<div class="d4p-group d4p-group-changelog">
    <h3><?php _e("Version", "dev4press-updater"); ?> 2</h3>
    <div class="d4p-group-inner">
        <h4>Version 2.4.1 / january 7 2015</h4>
        <ul>
            <li><strong>new</strong> support for GD WebFonts Toolbox Pro plugin</li>
        </ul>
        <h4>Version 2.4 / november 18 2014</h4>
        <ul>
            <li><strong>new</strong> support for GD Clever Widgets Pro plugin</li>
            <li><strong>new</strong> removed support for retired plugins</li>
            <li><strong>new</strong> removed panels for plugin modules</li>
            <li><strong>new</strong> using HTTPS URL's for connecting to Dev4Press website</li>
        </ul>
        <h4>Version 2.3 / april 13 2014</h4>
        <ul>
            <li><strong>edit</strong> improved plugin detection and build version retrieval</li>
            <li><strong>fix</strong> minor issues with the detecting of plugins information</li>
            <li><strong>fix</strong> several layout issues with themes install and updated</li>
        </ul>
        <h4>Version 2.2.2 / december 13 2013</h4>
        <ul>
            <li><strong>edit</strong> support for WordPress 3.7 and 3.8</li>
            <li><strong>fix</strong> problem with tabs switching on panels</li>
            <li><strong>fix</strong> few minor issues with the https websites</li>
        </ul>
        <h4>Version 2.2.1 / may 10 2013</h4><ul>
            <li><strong>edit</strong> improved to plugin javascript code</li>
            <li><strong>fix</strong> still broken urls for download of free plugins</li>
        </ul>
        <h4>Version 2.2 / feburary 15 2013</h4><ul>
            <li><strong>new</strong> show wordpress required versions for update</li>
            <li><strong>new</strong> show xscape core required versions for theme update</li>
            <li><strong>edit</strong> improved forming of free downloads url</li>
            <li><strong>edit</strong> additional update information for themes</li>
            <li><strong>edit</strong> deprecated themes functions replaced</li>
            <li><strong>fix</strong> several missing translation strings</li>
            <li><strong>fix</strong> broken urls for download of free plugins</li>
            <li><strong>fix</strong> broken urls for product icons</li>
        </ul>
        <h4>Version 2.1.1 / november 1 2012</h4><ul>
            <li><strong>edit</strong> additional links after installing new products</li>
            <li><strong>edit</strong> few improvements on installed and new panels</li>
            <li><strong>fix</strong> missing updates from the plugin dashboard</li>
            <li><strong>fix</strong> wrong labels for the installation of modules</li>
            <li><strong>fix</strong> broken installation and upgrade for modules</li>
            <li><strong>fix</strong> minor problems with the bulk upgrade and install</li>
            <li><strong>fix</strong> themes activation from the plugin installed panel</li>
            <li><strong>fix</strong> inconsistent display of some products lists</li>
            <li><strong>fix</strong> several incorrect links on some plugins panels</li>
        </ul>
        <h4>Version 2.1 / october 28 2012</h4><ul>
            <li><strong>new</strong> support for modules update and installation</li>
            <li><strong>new</strong> plugin dashboard panel with updater information</li>
            <li><strong>edit</strong> many small updates and improvements</li>
            <li><strong>edit</strong> updated serbian translation</li>
            <li><strong>fix</strong> broken urls for network multisite installations</li>
            <li><strong>fix</strong> updater links missing from the plugins panel</li>
            <li><strong>fix</strong> several minor styling issues with update panel</li>
            <li><strong>fix</strong> few issues with the bulk installer header</li>
        </ul>
        <h4>Version 2.0.1 / september 26 2012</h4><ul>
            <li><strong>new</strong> notice about clearing browser cache after the upgrade</li>
            <li><strong>fix</strong> in network environment gets stuck in maintenance mode</li>
        </ul>
        <h4>Version 2.0 / september 18 2012</h4><ul>
            <li><strong>new</strong> rewritten updater code to conform more to WP methods</li>
            <li><strong>new</strong> using tabbed interface for new and updated panels</li>
            <li><strong>new</strong> wordpress dashboard for the updater status and control</li>
            <li><strong>new</strong> additional auto updater scheduler intervals</li>
            <li><strong>new</strong> panel for easier purchase of plugins and themes</li>
            <li><strong>new</strong> system information widget for plugins home panel</li>
            <li><strong>new</strong> plugin dashboard expanded with promotions widget</li>
            <li><strong>new</strong> updated all button for the plugin dashboard</li>
            <li><strong>edit</strong> visual improvements to settings panel</li>
            <li><strong>edit</strong> visual improvements to installation interface</li>
            <li><strong>edit</strong> several improvements to the plugin core code</li>
            <li><strong>edit</strong> removed obsolete code for framework updates</li>
            <li><strong>fix</strong> inconsistent links to some of the redirects</li>
            <li><strong>fix</strong> several issues with the styling for the plugin panels</li>
            <li><strong>fix</strong> missing list of themes for update from plugin dashboard</li>
            <li><strong>fix</strong> broken installation of new free or lite plugins</li>
            <li><strong>fix</strong> improper use of the caps for install and update</li>
        </ul>
    </div>
</div>

<div class="d4p-group d4p-group-changelog">
    <h3><?php _e("Version", "dev4press-updater"); ?> 1</h3>
    <div class="d4p-group-inner">
        <h4>Version 1.9.2 / august 14 2012</h4><ul>
            <li><strong>new</strong> setting to disable auto checking</li>
            <li><strong>new</strong> setting for control of auto checking interval</li>
            <li><strong>edit</strong> updated process of the updates checking</li>
        </ul>
        <h4>Version 1.9.1 / august 5 2012</h4><ul>
            <li><strong>edit</strong> several minor changes to dashboard panel</li>
            <li><strong>fix</strong> problem with build detection for free plugins</li>
            <li><strong>fix</strong> downloading updates for free plugins</li>
        </ul>
        <h4>Version 1.9.0.1 / july 29 2012</h4><ul>
            <li><strong>fix</strong> critical bug with the detection of the plugin update</li>
        </ul>
        <h4>Version 1.9 / july 27 2012</h4><ul>
            <li><strong>new</strong> main plugin dashboard panel</li>
            <li><strong>edit</strong> overall improvements in the code</li>
        </ul>
        <h4>Version 1.8.7 / may 27 2012</h4><ul>
            <li><strong>edit</strong> support for latest bbpress plugins</li>
        </ul>
        <h4>Version 1.8.6 / may 13 2012</h4><ul>
            <li><strong>edit</strong> few improvements to toolbar menu integration</li>
            <li><strong>fix</strong> some issues with the get_plugins function</li>
        </ul>
        <h4>Version 1.8.5 / april 19 2012</h4><ul>
            <li><strong>new</strong> partial norwegian (nokmål) translation</li>
            <li><strong>edit</strong> minor changes to saving and checking updates</li>
            <li><strong>edit</strong> settings: api key displayed as password field</li>
            <li><strong>fix</strong> several minor warnings during update checkup</li>
        </ul>
        <h4>Version 1.8.4 / february 25 2012</h4><ul>
            <li><strong>edit</strong> using load_plugin_textdomain to load translation</li>
            <li><strong>fix</strong> creating update url for free plugins</li>
        </ul>
        <h4>Version 1.8.3 / february 8 2012</h4><ul>
            <li><strong>fix</strong> broken admin notice filter in network mode</li>
        </ul>
        <h4>Version 1.8.2 / february 1 2012</h4><ul>
            <li><strong>edit</strong> updated few translation strings</li>
            <li><strong>fix</strong> invalid path used for translations</li>
        </ul>
        <h4>Version 1.8.1 / january 30 2012</h4><ul>
            <li><strong>fix</strong> broken loading of translations</li>
            <li><strong>fix</strong> broken saving of plugin settings</li>
        </ul>
        <h4>Version 1.8 / january 29 2012</h4><ul>
            <li><strong>new</strong> admin side loading optimization</li>
            <li><strong>new</strong> support for wordpress 3.3 context help</li>
            <li><strong>fix</strong> core themes upgrades actions and filters</li>
            <li><strong>fix</strong> adding plugin menu under network admin</li>
            <li><strong>fix</strong> minor issue with missing update strings</li>
        </ul>
        <h4>Version 1.7 / october 27 2011</h4><ul>
            <li><strong>new</strong> support for managewp interactions</li>
            <li><strong>new</strong> adding update notice into the admin bar</li>
            <li><strong>edit</strong> plugin panels layouts improvements</li>
            <li><strong>fix</strong> context help links changed to new format</li>
            <li><strong>fix</strong> themes controls and links on update page</li>
        </ul>
        <h4>Version 1.6.3 / september 11 2011</h4><ul>
            <li><strong>new</strong> support for gd products center</li>
            <li><strong>new</strong> support for gd bbpress attachments</li>
            <li><strong>new</strong> support for all widget based plugins</li>
            <li><strong>edit</strong> minor styling changes to settings panel</li>
            <li><strong>fix</strong> can't install xscape core theme in some cases</li>
        </ul>
        <h4>Version 1.6.2 / june 11 2011</h4><ul>
            <li><strong>edit</strong> all upgrades available are auto checked</li>
            <li><strong>fix</strong> broken bulk upgrade for xscape framework only</li>
        </ul>
        <h4>Version 1.6.1 / june 10 2011</h4><ul>
            <li><strong>edit</strong> minor changes to check for update procedure</li>
            <li><strong>fix</strong> broken checks for the xscape core theme</li>
            <li><strong>fix</strong> installing core themes returns not found</li>
            <li><strong>fix</strong> log and debug into file was broken</li>
        </ul>
        <h4>Version 1.6.0 / june 5 2011</h4><ul>
            <li><strong>new</strong> updating plugins and themes with queue</li>
            <li><strong>new</strong> installing new plugins and themes with queue</li>
            <li><strong>new</strong> rewritten installer code to supports bulk operations</li>
            <li><strong>new</strong> nonce fields added for additional protection</li>
            <li><strong>new</strong> support for updating and installing of core themes</li>
            <li><strong>new</strong> showing plugin relevant context help</li>
            <li><strong>edit</strong> small change in displaying the plugins and themes info</li>
            <li><strong>fix</strong> checking for updates for plugins that were not activated</li>
            <li><strong>fix</strong> missing several translation strings from pot file</li>
            <li><strong>fix</strong> display of different status releases in the same time</li>
        </ul>
        <h4>Version 1.5.2 / april 22 2011</h4><ul>
            <li><strong>edit</strong> updated polish and serbian translation</li>
            <li><strong>edit</strong> minor code changes and improvements</li>
        </ul>
        <h4>Version 1.5.1 / march 24 2011</h4><ul>
            <li><strong>edit</strong> updated polish translation</li>
            <li><strong>fix</strong> displaying post updates links</li>
        </ul>
        <h4>Version 1.5.0 / january 28 2011</h4><ul>
            <li><strong>new</strong> install plugins and themes that are not already installed</li>
            <li><strong>new</strong> post install/upgrade plugins and themes operations</li>
            <li><strong>edit</strong> code cleanup and update for better performance</li>
            <li><strong>edit</strong> removed all unneeded code and libraries</li>
            <li><strong>fix</strong> getting themes info causes include recursion</li>
        </ul>
        <h4>Version 1.4.6 / january 23 2011</h4><ul>
            <li><strong>edit</strong> update notices displayed outside of network mode</li>
            <li><strong>edit</strong> update cron job removal when api key is missing</li>
            <li><strong>fix</strong> several invalid internal URL's in network mode</li>
            <li><strong>fix</strong> broken auto update check after completed updated</li>
        </ul>
        <h4>Version 1.4.5 / january 4 2011</h4><ul>
            <li><strong>new</strong> support for wp 3.1 network admin</li>
            <li><strong>edit</strong> using capabilities instead of levels</li>
            <li><strong>edit</strong> updated polish translation</li>
        </ul>
        <h4>Version 1.4.4 / october 16 2010</h4><ul>
            <li><strong>new</strong> support for gdHeadSpace4 plugin</li>
            <li><strong>fix</strong> several minor problems</li>
        </ul>
        <h4>Version 1.4.3 / august 25 2010</h4><ul>
            <li><strong>new</strong> update only framework in the themes</li>
            <li><strong>fix</strong> minor problems with displaying updates</li>
        </ul>
        <h4>Version 1.4.2 / august 20 2010</h4><ul>
            <li><strong>new</strong> update count number in the menu</li>
        </ul>
        <h4>Version 1.4.1 / august 16 2010</h4><ul>
            <li><strong>new</strong> support for gd azon fusion plugin</li>
        </ul>
        <h4>Version 1.4.0 / august 15 2010</h4><ul>
            <li><strong>new</strong> option to disable right now integration</li>
            <li><strong>new</strong> option to display admin notice when update is available</li>
            <li><strong>new</strong> show xScape framework version for themes</li>
            <li><strong>new</strong> allow plugin or theme to prevent update</li>
            <li><strong>edit</strong> improved and reorganized interface files</li>
            <li><strong>fix</strong> some problems with missing update info</li>
        </ul>
        <h4>Version 1.3.2 / july 29 2010</h4><ul>
            <li><strong>new</strong> polish translation</li>
        </ul>
        <h4>Version 1.3.1 / july 26 2010</h4><ul>
            <li><strong>fix</strong> problems with some translation strings</li>
        </ul>
        <h4>Version 1.3.0 / july 25 2010</h4><ul>
            <li><strong>new</strong> top level menu for the plugin</li>
            <li><strong>edit</strong> improved translation strings</li>
        </ul>
        <h4>Version 1.2.1 / june 11 2010</h4><ul>
            <li><strong>fix</strong> proper sending of update status</li>
            <li><strong>fix</strong> few minor improvements</li>
        </ul>
        <h4>Version 1.2.0 / april 27 2010</h4><ul>
            <li><strong>edit</strong> improved use for site admin on multi site</li>
            <li><strong>fix</strong> invalid timeout for the manual check</li>
        </ul>
        <h4>Version 1.1.0 / april 6 2010</h4><ul>
            <li><strong>new</strong> enable and control debug level settings</li>
            <li><strong>edit</strong> improved getting of plugin build number</li>
            <li><strong>edit</strong> changed url for geting update response</li>
            <li><strong>edit</strong> removed unneeded functions and files</li>
            <li><strong>fix</strong> problem with getting updates fro gd taxonomies tools</li>
            <li><strong>fix</strong> few minor problems with wordpress 3.0</li>
        </ul>
        <h4>Version 1.0.3 / april 2 2010</h4><ul>
            <li><strong>new</strong> getting theme data from theme info file</li>
            <li><strong>edit</strong> tested successfully on wpmu</li>
            <li><strong>fix</strong> missing function wp_redirect_self</li>
        </ul>
        <h4>Version 1.0.2 / april 1 2010</h4><ul>
            <li><strong>fix</strong> breaks the dashboard if update check fails</li>
        </ul>
        <h4>Version 1.0.1 / march 23 2010</h4><ul>
            <li><strong>edit</strong> improved pre and post update actions</li>
        </ul>
        <h4>Version 1.0.0 / march 21 2010</h4><ul>
            <li><strong>new</strong> first stable release</li>
        </ul>
    </div>
</div>
