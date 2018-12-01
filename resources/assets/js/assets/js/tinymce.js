// require('./components/admin/general');
// Core - these two are required :-)
import tinymce from 'tinymce/tinymce.min'
import 'tinymce/themes/modern/theme.min'


// Plugins
import 'tinymce/plugins/paste/plugin.min'
import 'tinymce/plugins/link/plugin.min'
import 'tinymce/plugins/autoresize/plugin.min'
import 'tinymce/plugins/lists/plugin.min'
import 'tinymce/plugins/fullscreen/plugin.min'
import 'tinymce/plugins/bbcode/plugin.min'
import 'tinymce/plugins/preview/plugin.min'


// Initialize
tinymce.init({
    selector: '#description',
    themes: 'inlite',
    skin: false,
    plugins: ['paste', 'link', 'autoresize', 'lists','fullscreen','preview']
});