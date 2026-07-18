import { usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { Mail, MapPin, Phone } from 'lucide-react';
import RevealText from '@/components/scrollxui/RevealText';
import EnquiryForm from '@/components/site/EnquiryForm';
import { makeSetting } from '@/lib/utils';

/**
 * Rose contact block — intro copy + contact details on the left,
 * the shared enquiry form on the right.
 */
export default function ContactBlock({
    id = 'contact',
    eyebrow,
    heading,
    intro,
    formProps = {},
}) {
    const setting = makeSetting(usePage().props?.settings);

    const email = setting('contact_email', 'hello@isla.com.au');
    const phone = setting('contact_phone', '+61 00 0000 0000');

    return (
        <section className="section" id={id}>
            <div className="container-site">
                <div className="block-rose">
                    <div className="grid gap-10 lg:grid-cols-2 lg:gap-14">
                        <motion.div
                            initial={{ opacity: 0, y: 24 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.55 }}
                        >
                            <p className="t-eyebrow mb-3">{eyebrow ?? setting('contact_eyebrow', 'Get started')}</p>
                            <RevealText text={heading ?? setting('contact_heading', 'Tell us about your business')} className="t-headline" />
                            <p className="mt-3 max-w-md opacity-80">
                                {intro ?? setting('contact_intro', "Send a few details and we'll come back with next steps within one business day.")}
                            </p>
                            <ul className="mt-8 flex flex-col gap-4 text-[15px] font-semibold">
                                <li className="flex items-center gap-3">
                                    <Mail className="h-[18px] w-[18px] text-rose-deep" strokeWidth={2.2} />
                                    <a href={`mailto:${email}`} className="hover:underline">{email}</a>
                                </li>
                                <li className="flex items-center gap-3">
                                    <Phone className="h-[18px] w-[18px] text-rose-deep" strokeWidth={2.2} />
                                    <a href={`tel:${String(phone).replace(/[^0-9+]/g, '')}`} className="hover:underline">{phone}</a>
                                </li>
                                <li className="flex items-center gap-3">
                                    <MapPin className="h-[18px] w-[18px] text-rose-deep" strokeWidth={2.2} />
                                    <span>{setting('contact_location', 'Supporting clients across Australia')}</span>
                                </li>
                            </ul>
                        </motion.div>
                        <EnquiryForm {...formProps} />
                    </div>
                </div>
            </div>
        </section>
    );
}
