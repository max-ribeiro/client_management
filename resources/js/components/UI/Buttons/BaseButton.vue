<template>
    <button :class="classes">
        <slot>
        </slot>
    </button>
</template>

<script>
export default {
    name: "Button",
    props: {
        variant: {
            type: String,
            default: "primary", // primary, secondary, danger
        },
        icon: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        classes() {
            const base =
                "flex flex-row justify-center items-center gap-2 rounded-lg text-sm font-medium transition h-[36px]";

            const availableTypeClasses = {
                primary: this.icon
                    ? `${base} px-3 py-2 min-w-[100px] left-48 top-6 
                        bg-[#321BDE] hover:bg-[#5946E4] active:bg-[#2715B0] focus:bg-[#2715B0] text-white`
                    : `${base} px-3 py-[9px] min-w-[72px] left-[38px] top-[92px] 
                        bg-[#321BDE] hover:bg-[#5946E4] active:bg-[#2715B0] focus:bg-[#2715B0] text-white`,

                secondary: this.icon
                    ? `${base} px-3 py-2 min-w-[100px] left-6 top-40 
                        bg-white hover:bg-[#F8F8F8] active:bg-[#E1E1E1] focus:bg-[#E1E1E1] 
                        text-[#505050] hover:text-[#505050] active:text-[#505050] focus:text-[#505050]`
                    : `${base} px-3 py-[9px] min-w-[72px] left-[38px] top-[200px] 
                        bg-white hover:bg-[#F8F8F8] active:bg-[#E1E1E1] focus:bg-[#E1E1E1] 
                        text-[#505050] hover:text-[#505050] active:text-[#505050] focus:text-[#505050]`,

                danger: this.icon
                    ? `${base} px-3 py-2 min-w-[100px] left-6 top-[296px] 
                        bg-white hover:bg-[#FAECE3] active:bg-[#F4CAB6] focus:bg-[#F4CAB6] 
                        text-[#E53935] hover:text-[#E53935] active:text-[#E53935] focus:text-[#E53935]`
                    : `${base} px-3 py-[9px] min-w-[72px] left-[38px] top-[340px] 
                        bg-white hover:bg-[#FAECE3] active:bg-[#F4CAB6] focus:bg-[#F4CAB6] 
                        text-[#E53935] hover:text-[#E53935] active:text-[#E53935] focus:text-[#E53935]`,
            };

            return availableTypeClasses[this.variant];
        },
    },
};
</script>
