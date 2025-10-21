export const variantClasses = {
    'default': [
        'text-black',
        'bg-white',
        'disabled:pointer-events-none',
        'disabled:opacity-50',
        'hover:bg-white/90',
        'h-9',
        'w-full',
        'inline-flex',
        'items-center',
        'justify-center',
        'text-sm',
        'font-medium',
        'transition-all'
    ],
    'gradient': [
        'bg-gradient-to-r',
        'from-blue-500',
        'to-purple-400',
        'hover:from-blue-600',
        'hover:to-purple-700',
        'shadow-2xl',
        'shadow-blue-500/50',
        'text-black'
    ],
    'dark': [
        'border',
        'border-gray-600',
        'g-gray-800/50',
        'hover:bg-gray-800'
    ]
};

export const baseClasses = [
    'px-3',
    'py-2',
    'rounded-lg',
    'text-lg',
    'font-medium'
];

export const getButtonClasses = (variant: string, customClass?: string) => [
    ...baseClasses,
    ...variantClasses[variant as keyof typeof variantClasses],
    customClass
].filter(Boolean)
