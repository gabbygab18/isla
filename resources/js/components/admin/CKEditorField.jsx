import { useEffect, useRef } from 'react';

const CKEDITOR_SRC = 'https://cdn.ckeditor.com/ckeditor5/43.3.1/classic/ckeditor.js';
let ckReady = null;

function loadCKEditor() {
    if (window.ClassicEditor) return Promise.resolve(window.ClassicEditor);
    if (!ckReady) {
        ckReady = new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = CKEDITOR_SRC;
            script.onload = () => resolve(window.ClassicEditor);
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
    return ckReady;
}

/**
 * React port of the CKEditor wiring in admin/blogs/form.blade.php. No
 * upload adapter configured on purpose — insertImage only offers "by URL",
 * which forces admins to link real (stock) photos instead of uploading
 * arbitrary files.
 */
export default function CKEditorField({ id, value, onChange }) {
    const elRef = useRef(null);
    const editorRef = useRef(null);

    useEffect(() => {
        let cancelled = false;

        loadCKEditor().then((ClassicEditor) => {
            if (cancelled || !elRef.current) return;
            ClassicEditor.create(elRef.current, {
                toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', 'blockQuote', '|', 'link', 'insertImage', '|', 'undo', 'redo'],
            }).then((editor) => {
                if (cancelled) {
                    editor.destroy().catch(() => {});
                    return;
                }
                editorRef.current = editor;
                editor.model.document.on('change:data', () => onChange(editor.getData()));
            });
        });

        return () => {
            cancelled = true;
            editorRef.current?.destroy().catch(() => {});
            editorRef.current = null;
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    return <textarea id={id} ref={elRef} defaultValue={value} />;
}
