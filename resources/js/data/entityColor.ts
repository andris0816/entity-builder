export const entityColorClasses: Record<string, { bg: string; text: string; border: string }> = {
    Character: {
        bg: "bg-blue-500/20",
        text: "text-blue-400",
        border: "border-blue-500/50"
    },
    Location: {
        bg: "bg-green-500/20",
        text: "text-green-400",
        border: "border-green-500/50"
    },
    Item: {
        bg: "bg-yellow-500/20",
        text: "text-yellow-400",
        border: "border-yellow-500/50"
    },
    Event: {
        bg: "bg-orange-500/20",
        text: "text-orange-400",
        border: "border-orange-500/50"
    },
};

export const defaultColorClasses = {
    bg: "bg-gray-500/20",
    text: "text-gray-400",
    border: "border-gray-500/50"
};
