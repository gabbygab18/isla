'use client';;
import { useState } from 'react';
import { motion } from 'motion/react';
import { cn } from '@/lib/utils';

/**
 * `expandedId` / `onExpandedChange` were added so a parent can drive this as a
 * controlled component (the talent bench auto-advances it). Without them the
 * only way to change the open card from outside was remounting via `key`,
 * which skipped the animation entirely.
 */
export default function ExpandableCards({
  cards,
  defaultExpanded = 1,
  expandedId: controlledId,
  onExpandedChange,
  transitionDuration = 0.5,
  className
}) {
  const [uncontrolledId, setUncontrolledId] = useState(defaultExpanded);
  const isControlled = controlledId !== undefined;
  const expandedId = isControlled ? controlledId : uncontrolledId;

  const setExpandedId = (id) => {
    if (!isControlled) setUncontrolledId(id);
    onExpandedChange?.(id);
  };

  const cardVariants = {
    expanded: {
      flex: 3,
      transition: { duration: transitionDuration, ease: [0.4, 0.0, 0.2, 1] },
    },
    collapsed: {
      flex: 1,
      transition: { duration: transitionDuration, ease: [0.4, 0.0, 0.2, 1] },
    },
  };

  return (
    <div className={cn('flex gap-3 sm:gap-4 w-full h-full', className)}>
      {cards.map((card) => {
        const isExpanded = expandedId === card.id;

        return (
          <motion.div
            key={card.id}
            className='relative h-full overflow-hidden rounded-2xl sm:rounded-3xl cursor-pointer'
            variants={cardVariants}
            initial={isExpanded ? 'expanded' : 'collapsed'}
            animate={isExpanded ? 'expanded' : 'collapsed'}
            onMouseEnter={() => setExpandedId(card.id)}>
            <div className='absolute inset-0'>{card.content}</div>

            {!isExpanded && (
              <motion.div
                className='absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors duration-300'
                initial={{ opacity: 0 }}
                whileHover={{ opacity: 1 }} />
            )}
          </motion.div>
        );
      })}
    </div>
  );
}
