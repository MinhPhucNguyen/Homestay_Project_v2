import AdminPage from "../layouts/admin.vue";
import DashboardPage from "../pages/Admin/Dashboard/Dashboard.vue";

// Users
import UsersList from "../pages/Admin/Users/index.vue";
import CreateUser from "../pages/Admin/Users/create.vue";
import EditUser from "../pages/Admin/Users/edit.vue";
import UserProfile from "../pages/Admin/Users/profile.vue";
import MainProfile from "../components/Admin/Profile/MainProfile.vue";

// Brands
import BrandsList from "../pages/Admin/Brands/index.vue";

// Send Email
import SendEmail from "../components/Admin/Profile/SendEmail.vue";

// Blogs
import BlogsList from "../pages/Admin/Blogs/index.vue";
import CreateBlog from "../pages/Admin/Blogs/create.vue";
import EditBlog from "../pages/Admin/Blogs/edit.vue";

// Cars
import CarsList from "../pages/Admin/Cars/index.vue";
import CreateCar from "../pages/Admin/Cars/create.vue";
import EditCar from "../pages/Admin/Cars/edit.vue";

// Features
import FeaturesList from "../pages/Admin/Features/index.vue";

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
          * Router for Brands Management
          */
         {
            path: "brands",
            component: BrandsList,
            name: "admin.brands",
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
          * Router for Car Management
          */
         {
            path: "cars",
            component: CarsList,
            name: "admin.cars",
         },
         {
            path: "cars/create",
            component: CreateCar,
            name: "cars.create",
         },
         {
            path: "cars/:id/edit",
            component: EditCar,
            name: "cars.edit",
         },

         /**
          * Router for  Feature Management
          */
         {
            path: "features",
            component: FeaturesList,
            name: "admin.features",
         },
      ],
   },
];

export default admin;
