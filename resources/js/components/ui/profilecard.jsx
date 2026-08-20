'use client';
import React, { useState, useRef } from 'react';
import { ArrowBigLeft, X } from 'lucide-react';
import {
  motion,
  useMotionValue,
  useTransform,
  useAnimation,
  AnimatePresence,
  useMotionTemplate,
} from 'motion/react';

/**
 * scrollxui `profilecard`, ported off Next.js — the upstream component imports
 * next/image and next/link, which don't exist in this Laravel + Inertia app, so
 * those are plain <img> / <a> here. Everything else is unchanged.
 */
export default function ProfileCard({
  img,
  name,
  bio,
  skills = [],
  socialLinks = [],
  position,
  spotlight = false,
  spotlightColor = '193, 117, 121'
}) {
  const [isRevealed, setIsRevealed] = useState(false);
  const [isImageShrunken, setIsImageShrunken] = useState(false);
  const arrowControls = useAnimation();
  const dragX = useMotionValue(0);
  const dragThreshold = 50;
  const isAnimating = useRef(false);

  const mouseX = useMotionValue(0);
  const mouseY = useMotionValue(0);
  const spotlightX = useMotionValue(0);
  const spotlightY = useMotionValue(0);
  const backgroundImage = useMotionTemplate`radial-gradient(300px circle at ${spotlightX}px ${spotlightY}px, rgba(${spotlightColor}, 0.15), transparent)`;

  const arrowRotation = useTransform(dragX, [0, dragThreshold], [-180, 145]);

  const handleDragEnd = () => {
    if (dragX.get() > dragThreshold && !isRevealed && !isAnimating.current) {
      isAnimating.current = true;
      arrowControls.start({ x: dragThreshold, transition: { duration: 0.2 } });
      setIsImageShrunken(true);
      setTimeout(() => {
        setIsRevealed(true);
        isAnimating.current = false;
      }, 400);
    } else if (dragX.get() <= dragThreshold && !isRevealed) {
      arrowControls.start({
        x: 0,
        transition: { type: 'spring', stiffness: 500, damping: 30 },
      });
    } else if (isRevealed) {
      arrowControls.start({
        x: dragThreshold,
        transition: { type: 'spring', stiffness: 500, damping: 30 },
      });
    }
  };

  const resetCard = () => {
    if (isRevealed && !isAnimating.current) {
      isAnimating.current = true;
      x.set(0);
      y.set(0);
      arrowControls.start({ x: 0, transition: { duration: 0.3 } });
      setIsRevealed(false);
      setTimeout(() => {
        setIsImageShrunken(false);
        isAnimating.current = false;
      }, 300);
    }
  };

  const x = useMotionValue(0);
  const y = useMotionValue(0);
  const rotateDepth = 12;
  const translateDepth = 15;

  const rotateX = useTransform(y, [-0.5, 0.5], [`-${rotateDepth}deg`, `${rotateDepth}deg`]);
  const rotateY = useTransform(x, [-0.5, 0.5], [`${rotateDepth}deg`, `-${rotateDepth}deg`]);
  const translateX = useTransform(x, [-0.5, 0.5], [`-${translateDepth}px`, `${translateDepth}px`]);
  const translateY = useTransform(y, [-0.5, 0.5], [`${translateDepth}px`, `-${translateDepth}px`]);

  const cardRef = useRef(null);

  const handleMouseMove = (e) => {
    if (!cardRef.current || !isRevealed || isAnimating.current) return;
    const rect = cardRef.current.getBoundingClientRect();
    const mouseXPos = e.clientX - rect.left;
    const mouseYPos = e.clientY - rect.top;

    const buffer = 10;
    if (
      mouseXPos < -buffer ||
      mouseXPos > rect.width + buffer ||
      mouseYPos < -buffer ||
      mouseYPos > rect.height + buffer
    )
      return;

    x.set(mouseXPos / rect.width - 0.5);
    y.set(mouseYPos / rect.height - 0.5);

    if (spotlight) {
      mouseX.set(mouseXPos);
      mouseY.set(mouseYPos);
      spotlightX.set(mouseXPos);
      spotlightY.set(mouseYPos);
    }
  };

  const handleMouseLeave = () => {
    if (isRevealed && !isAnimating.current) {
      setTimeout(() => {
        if (isRevealed && !isAnimating.current) {
          x.set(0);
          y.set(0);
        }
      }, 50);
    }
  };

  const renderSkillIcon = (skill) => {
    if (typeof skill.icon === 'string') {
      if (skill.icon.startsWith('<svg')) {
        return (
          <div
            dangerouslySetInnerHTML={{ __html: skill.icon }}
            className='w-5 h-5 flex items-center justify-center' />
        );
      }
      return <img src={skill.icon} alt={skill.name} width={20} height={20} />;
    }

    if (React.isValidElement(skill.icon)) {
      return React.cloneElement(skill.icon, {
        className: 'w-5 h-5'
      });
    }

    if (typeof skill.icon === 'function') {
      const IconComponent = skill.icon;
      return <IconComponent className='w-5 h-5' />;
    }

    return null;
  };

  return (
    <div className='flex items-center justify-center'>
      <motion.div
        ref={cardRef}
        className={`relative w-[17rem] h-[21.2rem] rounded-[15px] overflow-hidden shadow-lg bg-white text-ink ${
          spotlight && isRevealed ? 'group' : ''
        }`}
        onMouseMove={handleMouseMove}
        onMouseLeave={handleMouseLeave}
        style={
          isRevealed
            ? {
                rotateX,
                rotateY,
                translateX,
                translateY,
                transformStyle: 'preserve-3d',
                transition: 'transform 0.1s ease-out',
              }
            : {}
        }>
        {spotlight && isRevealed && (
          <motion.div
            className='pointer-events-none absolute -inset-px rounded-[15px] opacity-0 transition duration-300 group-hover:opacity-100'
            style={{ backgroundImage }} />
        )}
        <motion.div
          initial={{ width: '100%', height: '100%' }}
          animate={{
            width: isImageShrunken ? '6rem' : '100%',
            height: isImageShrunken ? '8rem' : '100%',
            top: isImageShrunken ? '4.5rem' : 0,
            left: isImageShrunken ? '1rem' : 0,
            borderRadius: isImageShrunken ? '0.5rem' : '0px',
          }}
          transition={{ duration: 0.4, ease: 'easeInOut' }}
          className='absolute overflow-hidden'>
          <img src={img} alt={name} className='absolute inset-0 h-full w-full object-cover' />

          <motion.div
            className='absolute top-2 right-2 w-[1.6875rem] h-[1.8125rem] flex items-center justify-center bg-white rounded shadow-sm cursor-grab active:cursor-grabbing z-10'
            drag={!isRevealed ? 'x' : false}
            dragConstraints={{ left: 0, right: dragThreshold }}
            dragElastic={0.1}
            dragMomentum={false}
            onDragEnd={handleDragEnd}
            style={{ x: dragX }}
            animate={arrowControls}
            whileTap={!isRevealed ? { scale: 1.1 } : {}}>
            <motion.div style={{ rotate: arrowRotation }}>
              <ArrowBigLeft className='w-4 h-4 text-black pointer-events-none' />
            </motion.div>
          </motion.div>
        </motion.div>

        <AnimatePresence>
          {isRevealed && (
            <motion.div
              key='content'
              className='absolute inset-0'
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 0.3 }}>
              <motion.div
                className='absolute top-2 right-2 w-6 h-6 flex items-center justify-center bg-ink rounded-full cursor-pointer z-20'
                onClick={resetCard}
                whileHover={{ scale: 1.1 }}
                whileTap={{ scale: 0.95 }}>
                <X className='w-4 h-4 text-cream' strokeWidth={2} />
              </motion.div>

              <div className='p-4'>
                <h1 className='text-xl font-bold tracking-wide text-ink'>{name}</h1>
                <p className='text-sm text-ink-soft'>{position}</p>
              </div>

              {skills.length > 0 && (
                <div className='absolute top-[4.5rem] left-32'>
                  <h3 className='text-lg font-semibold mb-2 text-ink'>Skills</h3>
                  <div className='flex flex-wrap gap-2'>
                    {skills.map((skill, index) => (
                      <div
                        key={index}
                        className={`bg-cream rounded-md p-1 flex items-center justify-center w-8 h-8 ${
                          spotlight ? 'group relative overflow-hidden' : ''
                        }`}
                        title={skill.name}
                        onMouseMove={
                          spotlight
                            ? (e) => {
                                const rect =
                                  e.currentTarget.getBoundingClientRect();
                                const x = e.clientX - rect.left;
                                const y = e.clientY - rect.top;
                                e.currentTarget.style.setProperty('--spotlight-x', `${x}px`);
                                e.currentTarget.style.setProperty('--spotlight-y', `${y}px`);
                              }
                            : undefined
                        }>
                        {spotlight && (
                          <div
                            className='pointer-events-none absolute -inset-px rounded-md opacity-0 transition duration-300 group-hover:opacity-100'
                            style={{
                              background: `radial-gradient(100px circle at var(--spotlight-x, 50%) var(--spotlight-y, 50%), rgba(${spotlightColor}, 0.2), transparent)`,
                            }} />
                        )}
                        <div className='relative z-10'>
                          {renderSkillIcon(skill)}
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              )}

              <div className='absolute top-52 left-0 px-4'>
                <p className='text-[13px] leading-relaxed text-ink-soft'>{bio}</p>
              </div>

              <div className='absolute bottom-4 left-4 flex gap-4'>
                {socialLinks.map((social, index) => {
                  const renderIcon = () => {
                    if (typeof social.icon === 'string') {
                      return <img src={social.icon} alt={social.name} className='absolute inset-0 h-full w-full object-contain' />;
                    } else if (React.isValidElement(social.icon)) {
                      return React.cloneElement(social.icon, {
                        className: 'w-5 h-5',
                        width: 20,
                        height: 20
                      });
                    } else if (typeof social.icon === 'function') {
                      const IconComponent = social.icon;
                      return <IconComponent className='w-5 h-5' />;
                    }
                    return null;
                  };

                  return (
                    <a key={index} href={social.url} target='_blank' rel='noreferrer'>
                      <div
                        className={`w-5 h-5 relative flex items-center justify-center ${
                          spotlight ? 'group overflow-hidden rounded' : ''
                        }`}
                        title={social.name}
                        onMouseMove={
                          spotlight
                            ? (e) => {
                                const rect =
                                  e.currentTarget.getBoundingClientRect();
                                const x = e.clientX - rect.left;
                                const y = e.clientY - rect.top;
                                e.currentTarget.style.setProperty('--spotlight-x', `${x}px`);
                                e.currentTarget.style.setProperty('--spotlight-y', `${y}px`);
                              }
                            : undefined
                        }>
                        {spotlight && (
                          <div
                            className='pointer-events-none absolute -inset-px rounded opacity-0 transition duration-300 group-hover:opacity-100'
                            style={{
                              background: `radial-gradient(80px circle at var(--spotlight-x, 50%) var(--spotlight-y, 50%), rgba(${spotlightColor}, 0.2), transparent)`,
                            }} />
                        )}
                        <div className='relative z-10'>{renderIcon()}</div>
                      </div>
                      <span className='sr-only'>{social.name}</span>
                    </a>
                  );
                })}
              </div>
            </motion.div>
          )}
        </AnimatePresence>

        {!isRevealed && !isImageShrunken && (
          <motion.div
            className='absolute top-2.5 right-[2.1875rem] text-white text-xs opacity-80 bg-black bg-opacity-50 px-2 py-1 rounded'
            initial={{ opacity: 0 }}
            animate={{
              opacity: [0, 0.8, 0],
              transition: { repeat: Infinity, duration: 2, repeatDelay: 1 },
            }}>
            Drag →
          </motion.div>
        )}
      </motion.div>
    </div>
  );
}
