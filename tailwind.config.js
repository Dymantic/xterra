module.exports = {
    theme: {
        extend: {
            fontSize: {
                "6xl": "3.5rem",
                banner: "5.25rem",
            },
            spacing: {
                42: "10.5rem",
                100: "25rem",
                "60": "15rem",
                "half-screen": "50vw",
            },
            height: {
                1: "0.2rem",
                "80": "20rem",
            },
            leading: {
                tight: "1.2",
            },
            lineHeight: {
                zero: "0",
            },
            maxHeight: {
                "48": "12rem",
            },
            minHeight: {
                banner: "50vw",
                "banner-tall": "120vw",
            },
            width: {
                "3/10": "30%",
                "9/10": "90%",
                "80": "20rem",
                "120": "30rem",
            },
            inset: {
                16: "4rem",
            },
            boxShadow: {
                top: "0 3px 6px rgba(0,0,0,.4)",
                big: "11px 15px 20px 0px rgba(0, 0, 0, 0.4)",
                small: "5px 5px 4px 0px rgba(0, 0, 0, 0.12)",
            },
            fontFamily: {
                heading: ["Barlow Condensed", "sans-serif"],
                body: ["Source Sans Pro", "sans-serif"],
                "body-serif": ["Source Serif Pro", "serif"],
            },
            colors: {
                "red-500": "#E5282D",
                "red-700": "#BA0C2F",
                "grey-700": "#2E2D2F",
                "grey-500": "#727071",
                "grey-200": "#EFEEEE",
                "grey-300": "#EEEDED",
                tinted: "rgba(0,0,0,0.4)",
                "tinted-dark": "rgba(0,0,0,0.9)",
                "blue-700": "#20327a",
                "blue-500": "#285ac8",
                "teal": "#37edd3",
            },
        },
    },
    variants: {
        textColor: ["responsive", "hover", "focus", "group-hover"],
        opacity: ["responsive", "hover", "focus", "group-hover"],
        display: ["responsive", "hover", "focus", "group-hover"],
    },
    plugins: [],
};
