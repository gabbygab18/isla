import { useCallback, useState } from 'react';
import Cropper from 'react-easy-crop';
import { Minus, Plus, RotateCw } from 'lucide-react';

const OUTPUT_SIZE = 600; // square px written back — plenty for avatars, keeps files small

/**
 * Draws the selected crop region onto an offscreen canvas at a fixed square
 * size and hands back a JPEG Blob, so what the admin frames is exactly what
 * gets uploaded (no server-side cropping needed).
 */
async function getCroppedBlob(imageSrc, cropPixels, rotation = 0) {
    const image = await new Promise((resolve, reject) => {
        const img = new Image();
        img.addEventListener('load', () => resolve(img));
        img.addEventListener('error', reject);
        img.src = imageSrc;
    });

    // Rotation happens on a first canvas so the crop maths below stays axis-aligned.
    const source = document.createElement('canvas');
    const sourceCtx = source.getContext('2d');
    const radians = (rotation * Math.PI) / 180;
    const sin = Math.abs(Math.sin(radians));
    const cos = Math.abs(Math.cos(radians));
    source.width = image.width * cos + image.height * sin;
    source.height = image.width * sin + image.height * cos;
    sourceCtx.translate(source.width / 2, source.height / 2);
    sourceCtx.rotate(radians);
    sourceCtx.drawImage(image, -image.width / 2, -image.height / 2);

    const canvas = document.createElement('canvas');
    canvas.width = OUTPUT_SIZE;
    canvas.height = OUTPUT_SIZE;
    const ctx = canvas.getContext('2d');
    ctx.imageSmoothingQuality = 'high';
    ctx.drawImage(
        source,
        cropPixels.x, cropPixels.y, cropPixels.width, cropPixels.height,
        0, 0, OUTPUT_SIZE, OUTPUT_SIZE,
    );

    return new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.9));
}

export default function ImageCropper({ src, fileName = 'photo.jpg', onCancel, onApply }) {
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);
    const [rotation, setRotation] = useState(0);
    const [cropPixels, setCropPixels] = useState(null);
    const [working, setWorking] = useState(false);

    const onCropComplete = useCallback((_area, areaPixels) => setCropPixels(areaPixels), []);

    const apply = async () => {
        if (!cropPixels) return;
        setWorking(true);
        try {
            const blob = await getCroppedBlob(src, cropPixels, rotation);
            const cropped = new File([blob], fileName.replace(/\.\w+$/, '') + '.jpg', { type: 'image/jpeg' });
            onApply(cropped);
        } finally {
            setWorking(false);
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center bg-ink/60 p-4" role="dialog" aria-modal="true">
            <div className="w-full max-w-lg overflow-hidden rounded-lg bg-white shadow-float">
                <div className="border-b border-hairline-soft px-6 py-4">
                    <h3 className="text-[16px] font-bold">Crop photo</h3>
                    <p className="mt-1 text-[13px] text-ink-soft">Drag to reposition, then zoom or rotate to frame the shot.</p>
                </div>

                <div className="relative h-[320px] w-full bg-ink/90">
                    <Cropper
                        image={src}
                        crop={crop}
                        zoom={zoom}
                        rotation={rotation}
                        aspect={1}
                        cropShape="round"
                        showGrid={false}
                        onCropChange={setCrop}
                        onZoomChange={setZoom}
                        onRotationChange={setRotation}
                        onCropComplete={onCropComplete}
                    />
                </div>

                <div className="flex flex-col gap-4 px-6 py-5">
                    <div className="flex items-center gap-3">
                        <button
                            type="button"
                            onClick={() => setZoom((z) => Math.max(1, +(z - 0.1).toFixed(2)))}
                            className="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md border border-hairline text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                            aria-label="Zoom out"
                        >
                            <Minus className="h-4 w-4" />
                        </button>
                        <input
                            type="range"
                            min={1}
                            max={3}
                            step={0.01}
                            value={zoom}
                            onChange={(e) => setZoom(Number(e.target.value))}
                            className="h-1.5 w-full cursor-pointer appearance-none rounded-full bg-hairline accent-rose-deep"
                            aria-label="Zoom"
                        />
                        <button
                            type="button"
                            onClick={() => setZoom((z) => Math.min(3, +(z + 0.1).toFixed(2)))}
                            className="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md border border-hairline text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                            aria-label="Zoom in"
                        >
                            <Plus className="h-4 w-4" />
                        </button>
                        <button
                            type="button"
                            onClick={() => setRotation((r) => (r + 90) % 360)}
                            className="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md border border-hairline text-ink-soft transition-colors hover:border-ink/40 hover:text-ink"
                            aria-label="Rotate 90 degrees"
                            title="Rotate"
                        >
                            <RotateCw className="h-4 w-4" />
                        </button>
                    </div>

                    <div className="flex justify-end gap-3">
                        <button
                            type="button"
                            onClick={onCancel}
                            className="rounded-md border border-hairline px-5 py-2.5 text-[14px] font-semibold text-ink transition-colors hover:bg-cream"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            onClick={apply}
                            disabled={working || !cropPixels}
                            className="rounded-md bg-ink px-5 py-2.5 text-[14px] font-semibold text-cream transition-colors hover:bg-ink/90 disabled:opacity-60"
                        >
                            {working ? 'Cropping…' : 'Apply crop'}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
