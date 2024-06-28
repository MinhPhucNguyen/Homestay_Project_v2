import AdminPage from "../layouts/admin.vue";
import DashboardPage from "../pages/Admin/Dashboard/Dashboard.vue";

// Users
import UsersList from "../pages/Admin/Users/index.vue";
import CreateUser from "../pages/Admin/Users/create.vue";
import EditUser from "../pages/Admin/Users/edit.vue";
import UserProfile from "../pages/Admin/Users/profile.vue";
import MainProfile from "../components/Admin/Profile/MainProfile.vue";

// Brands
import RoomTypesList from "../pages/Admin/RoomTypes/index.vue";

// Send Email
import SendEmail from "../components/Admin/Profile/SendEmail.vue";

// Blogs
import BlogsList from "../pages/Admin/Blogs/index.vue";
import CreateBlog from "../pages/Admin/Blogs/create.vue";
import EditBlog from "../pages/Admin/Blogs/edit.vue";

// Homestays
import HomestaysList from "../pages/Admin/Homestays/index.vue";
import CreateHomestay from "../pages/Admin/Homestays/create.vue";
import EditHomestay from "../pages/Admin/Homestays/edit.vue";

// Rooms
import RoomsList from "../pages/Admin/Rooms/index.vue";
import RoomEdit from "../pages/Admin/Rooms/edit.vue";
// Features
import FacilitiesList from "../pages/Admin/Facilities/index.vue";

const admin = [
   {
      path: "/admin",
      component: AdminPage,
      meta: {
         requiresAuth: true,
         permission: "admin",
      },
      children: [
         /**
          * Dashboard
          */
         {
            path: "dashboard",
            component: DashboardPage,
            name: "admin.dashboard",
         },

         /**
          * Router for Users Management
          */
         {
            path: "users",
            component: UsersList,
            name: "admin.users",
         },
         {
            path: "users/create",
            component: CreateUser,
            name: "admin.users.create",
         },
         {
            path: "users/:id/edit",
            component: EditUser,
            name: "admin.users.edit",
         },
         {
            path: "users/:id/profile",
            component: UserProfile,
            name: "admin.users.profile",
            children: [
               {
                  path: "",
                  component: MainProfile,
                  name: "admin.users.mainProfile",
               },
               {
                  path: "",
                  component: SendEmail,
                  name: "admin.users.sendEmail",
               },
            ],
            redirect: { name: "admin.users.mainProfile" },
         },

         /**
          * Router for Blog Management
          */
         {
            path: "blogs",
            component: BlogsList,
            name: "admin.blogs",
         },
         {
            path: "blogs/create",
            component: CreateBlog,
            name: "blogs.create",
         },
         {
            path: "blogs/:id/edit",
            component: EditBlog,
            name: "blogs.edit",
         },

         /**
          * Router for Homestay Management
          */
         {
            path: "homestays",
            component: HomestaysList,
            name: "admin.homestays",
         },
         {
            path: "homestays/create",
            component: CreateHomestay,
            name: "homestays.create",
         },
         {
            path: "homestays/:id/edit",
            component: EditHomestay,
            name: "homestays.edit",
         },

         /**
          * Router for  HomeTypes Management
          */
         {
            path: "room-types",
            component: RoomTypesList,
            name: "admin.room-types",
         },

         /**
          * Router for  Rooms Management
          */
         {
            path: "rooms",
            component: RoomsList,
            name: "admin.rooms",
         },
          {
              path: "rooms/edit",
              component: RoomEdit,
              name: "room.edit",
          },

         /**
          * Router for  HomeTypes Management
          */
         {
            path: "facilities",
            component: FacilitiesList,
            name: "admin.facilities",
         },
      ],
   },
];

export default admin;
