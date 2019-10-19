import axios from "axios";
import {notify} from "../components/Messaging/notify";
import {subDays, format} from 'date-fns';

export default {
    namespaced: true,

    state: {
        comments: [],
        replies: [],
        flagged: [],
        start_date: subDays(new Date(), 14),
        end_date: new Date(),
    },

    getters: {
      reviewable: state => {
          const comments = state.comments.map(comment => {
              return {
                  id: comment.id,
                  unique: `c_${comment.id}`,
                  type: 'comment',
                  body: comment.body,
                  context: comment.translation_title,
                  when: comment.time_ago,
                  timestamp: comment.timestamp,
                  author: comment.author,
              }
          });
          const replies = state.replies.map(reply => {
              return {
                  id: reply.id,
                  unique: `r_${reply.id}`,
                  type: 'reply',
                  body: reply.body,
                  context: reply.comment,
                  when: reply.time_ago,
                  timestamp: reply.timestamp,
                  author: reply.author,
              }
          });

          return [...comments, ...replies].sort((a,b) => b.timestamp - a.timestamp);
      },

        date_from: state => state.start_date.toDateString(),
        date_to: state => state.end_date.toDateString(),

        date_query: state => {
          const start = format(state.start_date, 'yyyy-MM-dd');
          const end = format(state.end_date, 'yyyy-MM-dd');

          return `?start=${start}&end=${end}`;
        }
    },

    mutations: {
        set_start(state, date) {
            state.start_date = date;
        },

        set_end(state, date) {
            state.end_date = date;
        }
    },

    actions: {

        hydrate({dispatch}) {
            dispatch('fetchComments').catch(notify.error);
            dispatch('fetchReplies').catch(notify.error);
            dispatch('fetchFlagged').catch(notify.error);
        },

        fetchComments({state, getters}) {
            return new Promise((resolve, reject) => {
               axios.get(`/admin/comments${getters.date_query}`)
                   .then(({data}) => {
                       state.comments = data;
                       resolve();
                   })
                   .catch(() => reject({message: 'Unable to fetch recent comments'}));
            });
        },

        fetchReplies({state, getters}) {
            return new Promise((resolve, reject) => {
                axios.get(`/admin/replies${getters.date_query}`)
                     .then(({data}) => {
                         state.replies = data;
                         resolve();
                     })
                     .catch(() => reject({message: 'Unable to fetch recent replies'}));
            });
        },

        fetchFlagged({state}) {
            return new Promise((resolve, reject) => {
               axios.get("/admin/flagged-comments")
                   .then(({data}) => {
                       state.flagged = data;
                       resolve();
                   })
                   .catch(() => reject({message: 'Unable to fetch flagged comments'}));
            });
        },

        deleteComment({dispatch}, id) {
            return new Promise((resolve, reject) => {
               axios.delete(`/admin/comments/${id}`)
                   .then(() => {
                       dispatch('fetchComments').catch(notify.error);
                       resolve();
                   })
                   .catch(() => reject({message: 'Unable to delete comment'}));
            });
        },

        deleteReply({dispatch}, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/admin/replies/${id}`)
                     .then(() => {
                         dispatch('fetchReplies').catch(notify.error);
                         resolve();
                     })
                     .catch(() => reject({message: 'Unable to delete reply'}));
            });
        },

        dismissFlag({dispatch}, flaggable_id) {
            return new Promise((resolve, reject) => {
               axios.delete(`/admin/rejected-flags/${flaggable_id}`)
                   .then(() => {
                       dispatch('fetchFlagged').catch(notify.error);
                       resolve();
                   })
                   .catch(() => reject({message: 'Unable to dismiss flag'}));
            });
        },

        removeFlaggedComment({dispatch}, flaggable_id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/admin/enforced-flags/${flaggable_id}`)
                     .then(() => {
                         dispatch('fetchFlagged').catch(notify.error);
                         resolve();
                     })
                     .catch(() => reject({message: 'Unable to delete flagged comment'}));
            });
        },
    }
}
