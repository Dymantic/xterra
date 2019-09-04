import UsersIndex from "../components/Users/Index";
import UsersList from "../components/Users/UsersList";
import NewUserForm from "../components/Users/NewUserForm";
import ShowUser from "../components/Users/Show";

export default [
    {
        path: '/users', component: UsersIndex,
        children: [
            {path: '', component: UsersList},
            {path:'create', component: NewUserForm}
        ]
    },
    {
        path: '/users/:id', component: ShowUser,
    }
];