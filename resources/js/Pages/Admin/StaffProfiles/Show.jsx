import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, Briefcase, Calendar, Clock, GraduationCap, Pencil, Wallet } from 'lucide-react';
import AdminProfileLayout from '@/Layouts/AdminProfileLayout';
import RevealText from '@/components/scrollxui/RevealText';
import Card from '@/components/scrollxui/Card';
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';

function StatBadge({ icon: Icon, label, value }) {
    if (!value) return null;
    return (
        <div className="rounded-lg border border-hairline-soft bg-white px-5 py-4">
            <div className="flex items-center gap-2 text-ink-soft">
                <Icon className="h-4 w-4" strokeWidth={2.2} />
                <span className="t-caption">{label}</span>
            </div>
            <p className="mt-1.5 text-[15px] font-bold text-ink">{value}</p>
        </div>
    );
}

function Pill({ children }) {
    return (
        <span className="rounded-pill border border-hairline bg-white px-3.5 py-1.5 text-[13px] font-medium text-ink-soft">
            {children}
        </span>
    );
}

function JobCard({ job, i }) {
    return (
        <motion.div
            initial={{ opacity: 0, x: -16 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true, margin: '-10% 0px' }}
            transition={{ duration: 0.45, delay: i * 0.05 }}
            className="relative rounded-lg border border-hairline-soft bg-white p-6 pl-8"
        >
            <span aria-hidden="true" className="absolute inset-y-6 left-0 w-[3px] rounded-full bg-rose-deep" />
            <div className="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
                <h3 className="font-display text-[17px] font-bold">{job.title}</h3>
                {job.period && <span className="t-caption text-ink-soft/70">{job.period}</span>}
            </div>
            <p className="mt-1 text-[14px] font-semibold text-rose-deep">{job.company}</p>
            {job.bullets?.length > 0 && (
                <ul className="mt-3.5 flex flex-col gap-2">
                    {job.bullets.map((line, li) => (
                        <li key={li} className="flex items-start gap-2.5 text-[14.5px] leading-relaxed text-ink-soft">
                            <span className="mt-2 h-1 w-1 shrink-0 rounded-full bg-sage-deep" />
                            {line}
                        </li>
                    ))}
                </ul>
            )}
        </motion.div>
    );
}

function ExperienceList({ jobs }) {
    return (
        <div className="flex flex-col gap-6">
            {jobs.map((job, i) => <JobCard key={i} job={job} i={i} />)}
        </div>
    );
}

export default function StaffProfileShow({ profile, others = [] }) {
    const {
        slug, name, role_title: roleTitle, category, about_me: aboutMe, rate, work_preference: workPreference,
        photo_display_url: photoUrl,
        availability, experience, education, core_skills: coreSkillsRaw, software_expertise: softwareExpertiseRaw,
        certifications: certificationsRaw, affiliations: affiliationsRaw,
    } = profile;

    // JSON-cast columns come through as `null` (not `undefined`) when empty
    // in the DB, so destructuring defaults don't apply — coerce explicitly.
    const experienceList = experience || [];
    const educationList = education || [];
    const coreSkills = coreSkillsRaw || [];
    const softwareExpertise = softwareExpertiseRaw || [];
    const certifications = certificationsRaw || [];
    const affiliations = affiliationsRaw || [];

    return (
        <AdminProfileLayout title={name}>
            {/* ── HERO — big kinetic name, ScrollXUI reveal-text ──────── */}
            <section className="relative overflow-hidden pb-10 pt-14 md:pt-20">
                <div className="container-site">
                    <div className="mb-6 flex flex-wrap items-center gap-3">
                        <Link href="/admin/staff-profiles" className="text-[13.5px] font-semibold text-ink-soft transition-colors hover:text-ink">
                            ← All profiles
                        </Link>
                        {category && (
                            <span className="rounded-pill bg-sage-soft px-3 py-1 text-[11.5px] font-bold uppercase tracking-wide text-sage-deep">
                                {category}
                            </span>
                        )}
                        {availability && (
                            <span className="inline-flex items-center gap-1.5 rounded-pill bg-rose-soft px-3 py-1 text-[11.5px] font-bold text-rose-deep">
                                <span className="h-1.5 w-1.5 rounded-full bg-rose-deep" />
                                Available {availability.toLowerCase()}
                            </span>
                        )}
                        <Link
                            href={`/admin/staff-profiles/${slug}/edit`}
                            className="ml-auto inline-flex items-center gap-2 rounded-pill border border-hairline bg-white px-4 py-1.5 text-[13px] font-semibold text-ink transition-colors hover:border-ink/40"
                        >
                            <Pencil className="h-3.5 w-3.5" strokeWidth={2.2} />
                            Edit
                        </Link>
                    </div>

                    <div className="flex flex-wrap items-center gap-6">
                        {photoUrl && (
                            <motion.span
                                initial={{ opacity: 0, scale: 0.94 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ duration: 0.5 }}
                                className="h-28 w-28 shrink-0 overflow-hidden rounded-full border border-hairline shadow-card"
                            >
                                <img src={photoUrl} alt={name} className="h-full w-full object-cover" />
                            </motion.span>
                        )}
                        <div className="min-w-0">
                            <RevealText text={name} as="h1" className="t-display-xl" />
                            <motion.p
                                initial={{ opacity: 0, y: 12 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: 0.35, duration: 0.5 }}
                                className="t-body-lg mt-3 max-w-2xl font-semibold text-ink-soft"
                            >
                                {roleTitle}
                            </motion.p>
                        </div>
                    </div>

                    <motion.div
                        initial={{ opacity: 0, y: 16 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: 0.45, duration: 0.5 }}
                        className="mt-8 grid gap-3 sm:grid-cols-3 sm:max-w-2xl"
                    >
                        <StatBadge icon={Wallet} label="Rate" value={rate} />
                        <StatBadge icon={Clock} label="Preference" value={workPreference} />
                        <StatBadge icon={Calendar} label="Availability" value={availability} />
                    </motion.div>
                </div>
            </section>

            <div className="container-site grid gap-10 pb-20 lg:grid-cols-[1.6fr_1fr]">
                {/* ── MAIN COLUMN ──────────────────────────────────────── */}
                <div className="flex flex-col gap-12">
                    {aboutMe && (
                        <motion.div initial={{ opacity: 0, y: 20 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} transition={{ duration: 0.5 }}>
                            <h2 className="t-card-title mb-3">About</h2>
                            <p className="max-w-2xl text-[15.5px] leading-relaxed text-ink-soft">{aboutMe}</p>
                        </motion.div>
                    )}

                    {experienceList.length > 0 && (
                        <div>
                            <h2 className="t-card-title mb-5 flex items-center gap-2">
                                <Briefcase className="h-[18px] w-[18px] text-rose-deep" strokeWidth={2.2} />
                                Work Experience
                            </h2>
                            <ExperienceList jobs={experienceList} />
                        </div>
                    )}

                    {educationList.length > 0 && (
                        <div>
                            <h2 className="t-card-title mb-5 flex items-center gap-2">
                                <GraduationCap className="h-[18px] w-[18px] text-sage-deep" strokeWidth={2.2} />
                                Education
                            </h2>
                            <div className="flex flex-col gap-3">
                                {educationList.map((edu, i) => (
                                    <div key={i} className="rounded-lg border border-hairline-soft bg-white p-5">
                                        <p className="font-display text-[15.5px] font-bold">{edu.school}</p>
                                        {edu.degree && <p className="mt-0.5 text-[14px] text-ink-soft">{edu.degree}</p>}
                                        {edu.period && <p className="t-caption mt-1.5 text-ink-soft/70">{edu.period}</p>}
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}

                    {certifications.length > 0 && (
                        <div>
                            <h2 className="t-card-title mb-4">Licenses &amp; Certifications</h2>
                            <ul className="flex flex-col gap-2">
                                {certifications.map((c, i) => (
                                    <li key={i} className="flex items-start gap-2.5 text-[14.5px] leading-relaxed text-ink-soft">
                                        <span className="mt-2 h-1 w-1 shrink-0 rounded-full bg-rose-deep" />
                                        {c}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    {affiliations.length > 0 && (
                        <div>
                            <h2 className="t-card-title mb-4">Affiliations</h2>
                            <ul className="flex flex-col gap-2">
                                {affiliations.map((a, i) => (
                                    <li key={i} className="flex items-start gap-2.5 text-[14.5px] leading-relaxed text-ink-soft">
                                        <span className="mt-2 h-1 w-1 shrink-0 rounded-full bg-sage-deep" />
                                        {a}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>

                {/* ── SIDEBAR ──────────────────────────────────────────── */}
                <motion.aside
                    initial={{ opacity: 0, y: 20 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.5, delay: 0.1 }}
                    className="flex h-fit flex-col gap-8 lg:sticky lg:top-24"
                >
                    {coreSkills.length > 0 && (
                        <div className="rounded-lg bg-rose-soft p-6">
                            <h3 className="t-caption mb-4 text-rose-deep">Core Skills</h3>
                            <div className="flex flex-wrap gap-2">
                                {coreSkills.map((skill, i) => <Pill key={i}>{skill}</Pill>)}
                            </div>
                        </div>
                    )}

                    {softwareExpertise.length > 0 && (
                        <div className="rounded-lg bg-sage-soft p-6">
                            <h3 className="t-caption mb-4 text-sage-deep">Software Expertise</h3>
                            <div className="flex flex-wrap gap-2">
                                {softwareExpertise.map((tool, i) => <Pill key={i}>{tool}</Pill>)}
                            </div>
                        </div>
                    )}

                    <div className="rounded-lg border border-hairline-soft bg-white p-6">
                        <h3 className="t-caption mb-4 text-ink-soft">Engagement Details</h3>
                        <Table>
                            <TableBody>
                                {[['Rate', rate], ['Work preference', workPreference], ['Availability', availability]]
                                    .filter(([, v]) => v)
                                    .map(([k, v]) => (
                                        <TableRow key={k} className="border-hairline-soft">
                                            <TableCell className="whitespace-normal px-0 py-2.5 text-[14px] text-ink-soft">{k}</TableCell>
                                            <TableCell className="whitespace-normal px-0 py-2.5 text-right text-[14px] font-semibold text-ink">{v}</TableCell>
                                        </TableRow>
                                    ))}
                            </TableBody>
                        </Table>
                    </div>
                </motion.aside>
            </div>

            {others.length > 0 && (
                <section className="section-tight pt-0">
                    <div className="container-site">
                        <p className="t-eyebrow mb-3 text-rose-deep">More from the bench</p>
                        <h2 className="t-headline mb-8">Other profiles</h2>
                        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            {others.map((item) => (
                                <Card key={item.id} href={`/admin/staff-profiles/${item.slug}`} className="flex h-full flex-col">
                                    <h3 className="t-card-title text-[16px]">{item.name}</h3>
                                    <p className="mt-1.5 flex-1 text-[13.5px] text-ink-soft">{item.role_title}</p>
                                    <span className="mt-4 inline-flex items-center gap-1.5 text-[13px] font-bold text-rose-deep">
                                        View <ArrowRight className="h-3.5 w-3.5" strokeWidth={2.4} />
                                    </span>
                                </Card>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </AdminProfileLayout>
    );
}
