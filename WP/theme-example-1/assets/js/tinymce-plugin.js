(function () {
    tinymce.PluginManager.add('columns', function (editor, url) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('columns', {
            title: 'Insert Column',
            cmd: 'columns',
            image: url + "/../img/container.svg",
        });

        editor.addCommand('columns', function () {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            var node = editor.selection.getNode();
            if (node.classList.contains("container")) {
                var nodes = editor.selection.getNode();
                var parent = nodes.parentNode;
                var text = parent.innerText;
                editor.execCommand('mceRemoveNode', false, nodes);
                editor.execCommand('mceRemoveNode', false, parent);
                return;
            }
            if (selected_text.length === 0) {
                alert('Please select some text.');
                return;
            }
            var open_column = '<div class="container">';
            var close_column = '</div>';
            var return_text = '';
            return_text = open_column + selected_text + close_column;
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });

    });
})();