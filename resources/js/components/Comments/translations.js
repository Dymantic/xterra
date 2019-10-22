const translations = {

    comments: {
        default_name: {
            en: 'Post using your Facebook identity',
            zh: 'ZH Post using your Facebook identity',
        },
        button_post: {
            en: 'Post it',
            zh: 'ZH Post it',
        },
        button_cancel: {
            en: 'Cancel',
            zh: 'ZH Cancel',
        },
        button_send: {
            en: 'Send Reply',
            zh: 'ZH Send',
        },
        error: {
            en: 'There was problem posting your comment. Please refresh the page and try again.',
            zh: 'ZH There was problem posting your comment. Please refresh the page and try again.',
        },
        reply_error: {
            en: 'There was problem posting your reply. Please refresh the page and try again.',
            zh: 'ZH There was problem posting your reply. Please refresh the page and try again.',
        }
    },

    flagging: {
        title: {
            en: 'Flag this comment by ',
            zh: 'ZH Flag this comment by ',
        },
        instruction: {
            en: 'Tell us why this comment offends you, and we will review and delete it if we agree it does not meet our standards.',
            zh: 'ZH Tell us why this comment offends you, and we will review and delete it if we agree it does not meet our standards.',
        },
        label: {
            en: 'I find this offensive because...',
            zh: 'ZH I find this offensive because...',
        },
        error: {
            en: 'Failed to flag this comment. Please refresh and try again.',
            zh: 'ZH Failed to flag this comment. Please refresh and try again.',
        },
        done: {
            en: 'This comment has already been flagged and is awaiting for review.',
            zh: 'ZH This comment has already been flagged and is awaiting for review.',
        },
        button_confirm: {
            en: 'Yes, flag it!',
            zh: 'ZH Yes, flag it!',
        },
        button_cancel: {
            en: 'Cancel',
            zh: 'ZH Cancel',
        },
        button_okay: {
            en: 'Okay',
            zh: 'ZH Okay',
        }
    },
};

function trans(path, lang) {
    const parts = path.split('.');
    const bucket = parts[0];
    const string = parts[1];

    return translations[bucket][string][lang];


}

export {trans};
