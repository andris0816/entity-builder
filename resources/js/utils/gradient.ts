export const gradientClasses = [
    'gradient-red',
    'gradient-orange',
    'gradient-amber',
    'gradient-yellow',
    'gradient-lime',
    'gradient-green',
    'gradient-emerald',
    'gradient-teal',
    'gradient-cyan',
    'gradient-sky',
    'gradient-blue',
    'gradient-indigo',
    'gradient-violet',
    'gradient-purple',
    'gradient-fuchsia',
    'gradient-pink',
    'gradient-rose',
] as const;

export function getRandomGradient(): string {
    return gradientClasses[Math.floor(Math.random() * gradientClasses.length)];
}
