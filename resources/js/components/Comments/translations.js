const translations = {

    comments: {
        default_name: {
            en: 'Post using your Facebook identity',
            zh: '使用 Facebook 身份留言',
        },
        button_post: {
            en: 'Post it',
            zh: '送出',
        },
        button_cancel: {
            en: 'Cancel',
            zh: '取消',
        },
        button_send: {
            en: 'Send Reply',
            zh: '回覆',
        },
        error: {
            en: 'There was problem posting your comment. Please refresh the page and try again.',
            zh: '目前無法送出留言，請重新載入頁面後再試一次',
        },
        reply_error: {
            en: 'There was problem posting your reply. Please refresh the page and try again.',
            zh: '目前無法送出回覆，請重新載入頁面後再試一次',
        }
    },

    flagging: {
        title: {
            en: 'Flag this comment by ',
            zh: '檢舉這則留言',
        },
        instruction: {
            en: 'Tell us why this comment offends you, and we will review and delete it if we agree it does not meet our standards.',
            zh: '請告訴我們這則留言有何問題，我們會進行審核',
        },
        label: {
            en: 'I find this offensive because...',
            zh: '我認為這則留言不妥，因為…',
        },
        error: {
            en: 'Failed to flag this comment. Please refresh and try again.',
            zh: '無法檢舉此則留言，請重新載入頁面後再試一次',
        },
        done: {
            en: 'This comment has already been flagged and is awaiting for review.',
            zh: '本留言已遭檢舉，等候審核中',
        },
        button_confirm: {
            en: 'Yes, flag it!',
            zh: '是的，我要檢舉',
        },
        button_cancel: {
            en: 'Cancel',
            zh: '取消',
        },
        button_okay: {
            en: 'Okay',
            zh: '好的',
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
