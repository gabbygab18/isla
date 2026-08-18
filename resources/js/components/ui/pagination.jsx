'use client';;
import * as React from 'react';
import { ChevronLeft, ChevronRight, MoreHorizontal } from 'lucide-react';
import { cn } from '@/lib/utils';
import { Badge } from '@/components/ui/badge';
import { motion } from 'motion/react';

const Pagination = ({
  className,
  ...props
}) => (
  <nav
    role='navigation'
    aria-label='pagination'
    className={cn('mx-auto flex w-full justify-center', className)}
    {...props} />
);
Pagination.displayName = 'Pagination';

const PaginationContent = React.forwardRef(({ className, ...props }, ref) => (
  <ul
    ref={ref}
    className={cn('flex flex-row items-center gap-1 sm:gap-2', className)}
    {...props} />
));
PaginationContent.displayName = 'PaginationContent';

const PaginationItem = React.forwardRef(({ className, ...props }, ref) => (
  <li ref={ref} className={cn('list-none', className)} {...props} />
));
PaginationItem.displayName = 'PaginationItem';

const MotionBadge = motion(Badge);
const MotionDiv = motion.div;
const MotionSpan = motion.span;

const PaginationLink = React.forwardRef((
  {
    className,
    isActive = false,
    shiny = isActive,
    shinySpeed = 5,
    size = 'icon',
    variant,
    children,
    ...props
  },
  ref,
) => {
  const badgeVariant = variant || (isActive ? 'default' : 'outline-solid');

  return (
    <a
      ref={ref}
      className={cn(
        'inline-flex items-center justify-center rounded-full',
        'focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-ring',
        size === 'icon'
          ? 'h-8 w-8 sm:h-9 sm:w-9'
          : 'h-9 px-3 py-1 sm:h-10 sm:px-4 sm:py-2',
        className
      )}
      {...props}>
      <MotionBadge
        variant={badgeVariant}
        shiny={shiny}
        shinySpeed={shinySpeed}
        className={cn('h-full w-full items-center justify-center', 'border shadow-xs', isActive
          ? 'bg-primary text-primary-foreground border-primary'
          : 'border-input bg-background', !isActive && 'hover:bg-accent hover:text-accent-foreground', size === 'icon' ? 'p-0' : 'px-2 py-1 sm:px-3 sm:py-1')}
        whileHover={
          !isActive
            ? {
                scale: 1.05,
                transition: { type: 'spring', stiffness: 400, damping: 10 },
              }
            : {}
        }
        whileTap={
          !isActive
            ? {
                scale: 0.95,
                transition: { type: 'spring', stiffness: 400, damping: 10 },
              }
            : {}
        }
        animate={
          isActive
            ? {
                scale: [1, 1.02, 1],
                transition: {
                  repeat: Infinity,
                  repeatType: 'reverse',
                  duration: 2,
                },
              }
            : {}
        }>
        {children}
      </MotionBadge>
    </a>
  );
});
PaginationLink.displayName = 'PaginationLink';

const PaginationPrevious = React.forwardRef(({ className, ...props }, ref) => {
  return (
    <PaginationLink
      ref={ref}
      aria-label='Go to previous page'
      size='default'
      className={cn('pl-2 sm:pl-2.5', className)}
      {...props}>
      <MotionDiv
        className='flex items-center gap-1'
        whileHover={{ x: -2 }}
        whileTap={{ x: -4 }}>
        <ChevronLeft className='h-4 w-4' />
        <span className='hidden sm:inline'>Previous</span>
      </MotionDiv>
    </PaginationLink>
  );
});
PaginationPrevious.displayName = 'PaginationPrevious';

const PaginationNext = React.forwardRef(({ className, ...props }, ref) => {
  return (
    <PaginationLink
      ref={ref}
      aria-label='Go to next page'
      size='default'
      className={cn('pr-2 sm:pr-2.5', className)}
      {...props}>
      <MotionDiv
        className='flex items-center gap-1'
        whileHover={{ x: 2 }}
        whileTap={{ x: 4 }}>
        <span className='hidden sm:inline'>Next</span>
        <ChevronRight className='h-4 w-4' />
      </MotionDiv>
    </PaginationLink>
  );
});
PaginationNext.displayName = 'PaginationNext';

const PaginationEllipsis = React.forwardRef(({ className, ...props }, ref) => {
  return (
    <MotionSpan
      ref={ref}
      aria-hidden
      className={cn(
        'flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center text-muted-foreground',
        className
      )}
      whileHover={{ scale: 1.1 }}
      {...props}>
      <MoreHorizontal className='h-4 w-4' />
      <span className='sr-only'>More pages</span>
    </MotionSpan>
  );
});
PaginationEllipsis.displayName = 'PaginationEllipsis';

export {
  Pagination,
  PaginationContent,
  PaginationLink,
  PaginationItem,
  PaginationPrevious,
  PaginationNext,
  PaginationEllipsis,
};
