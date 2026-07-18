import { usePage } from '@inertiajs/react';
import SiteLayout from '@/Layouts/SiteLayout';
import ContactBlock from '@/components/site/ContactBlock';
import PageHero from '@/components/site/PageHero';
import { makeSetting } from '@/lib/utils';

export default function Contact() {
    const setting = makeSetting(usePage().props?.settings);

    return (
        <SiteLayout title="Contact" description={setting('contact_intro', 'Tell us about your business.')}>
            <PageHero crumbs={[{ label: 'Contact' }]} />
            <div className="-mt-8">
                <ContactBlock />
            </div>
        </SiteLayout>
    );
}
