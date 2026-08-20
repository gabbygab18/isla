import { useState } from 'react';
import { Check, Copy } from 'lucide-react';

export default function CopyLinkButton({ url, label = 'Copy link', className = '' }) {
    const [copied, setCopied] = useState(false);

    const copy = async () => {
        try {
            await navigator.clipboard.writeText(url);
        } catch {
            // clipboard API needs a secure context (https/localhost) — fall back
            // to a throwaway textarea so copying still works over plain http.
            const el = document.createElement('textarea');
            el.value = url;
            el.style.position = 'fixed';
            el.style.opacity = '0';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }
        setCopied(true);
        setTimeout(() => setCopied(false), 1800);
    };

    return (
        <button
            type="button"
            onClick={copy}
            title={url}
            className={`inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1.5 text-[12.5px] font-semibold transition-colors ${
                copied
                    ? 'border-sage-deep bg-sage-soft text-sage-deep'
                    : 'border-hairline bg-white text-ink-soft hover:border-ink/40 hover:text-ink'
            } ${className}`}
        >
            {copied ? <Check className="h-3.5 w-3.5" strokeWidth={2.4} /> : <Copy className="h-3.5 w-3.5" />}
            {copied ? 'Copied' : label}
        </button>
    );
}
