'use client';;
import { motion } from 'motion/react';
import { TypeAnimation } from 'react-type-animation';
import { cn } from '@/lib/utils';

/**
 * Upstream defaults built the gradient from interpolated class names
 * (`from-${gradientFrom}`) using Tailwind v4's `bg-linear-to-r`. Neither works
 * here: this project is on Tailwind v3 (`bg-gradient-to-r`), and the JIT
 * scanner can't see runtime-built class strings, so those utilities were never
 * generated. Pass the gradient in via `className` instead.
 */
const Typeanimation = ({
  words = [' existence', ' reality', ' the Internet'],
  className,
  typingSpeed = 50,
  deletingSpeed = 50,
  pauseDuration = 1000,
}) => {
  const sequence = words.flatMap((word) => [word, pauseDuration]);

  return (
    <motion.span
      className={cn('inline-block', className)}
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 1 }}>
      <TypeAnimation
        sequence={sequence}
        wrapper='span'
        repeat={Infinity}
        className=''
        speed={typingSpeed}
        deletionSpeed={deletingSpeed} />
    </motion.span>
  );
};

export default Typeanimation;
