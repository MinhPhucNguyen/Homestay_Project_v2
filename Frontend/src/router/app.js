import { useStore } from "vuex";

const app = [
   {
      path: "/",
      component: () => import("../layouts/app.vue"),
      meta: {
         permission: "user",
      },
      children: [
         {
            path: "/",
            component: () => import("../pages/HomePage/HomePage.vue"),
            name: "home",
         },
         {
            path: "about",
            component: () => import("../pages/AboutPage/AboutPage.vue"),
         },
         {
            path: "car/:carname/:id",
            component: () => import("../pages/CarDetail/CarDetail.vue"),
         },
         {
            path: "blog",
            component: () => import("../pages/BlogPage/BlogPage.vue"),
         },
         {
            path: "blog/:slug",
            component: () => import("../pages/BlogDetail/BlogDetail.vue"),
            name: "blogDetail",
         },
         {
            path: "find/filter",
            component: () => import("../pages/FindCar/index.vue"),
            name: "findCar",
            meta: {
               hideFooter: true,
            },
         },
         {
            path: "authorize/:provider/callback",
            component: () => import("../pages/Auth/LoginSocial.vue"),
            name: "socialLogin",
            meta: {
               hideFooter: true,
               hideNavbar: true,
            },
         },
         {
            path: "login",
            component: () => import("../pages/Auth/LoginPage.vue"),
            name: "login",
            meta: {
               hideFooter: true,
            },
         },
         {
            path: "register",
            component: () => import("../pages/Auth/RegisterPage.vue"),
            name: "register",
            meta: {
               hideFooter: true,
            },
         },
         {
            path: "forgot-password",
            component: () => import("../pages/Auth/ForgotPassword.vue"),
            name: "forgotPassword",
            meta: {
               hideFooter: true,
            },
         },
         {
            path: "reset-password",
            component: () => import("../pages/Auth/ResetPassword.vue"),
            name: "resetPassword",
            meta: {
               hideFooter: true,
            },
         },
         {
            path: "account",
            component: () => import("../pages/AccountPage/AccountPage.vue"),
            name: "account",
            meta: {
               requiresAuth: true,
            },
            beforeEnter: (to, from, next) => {
               if (useStore().getters["auth/getUser"] && to.path === "/account") {
                  next();
               }
            },
            children: [
               {
                  path: "/account",
                  component: () => import("../pages/AccountPage/AccountContent/AccountContent.vue"),
                  name: "accountContent",
               },
               {
                  path: "/myfavs",
                  component: () => import("../pages/AccountPage/MyFavs/MyFavs.vue"),
               },
               {
                  path: "/resetpw",
                  component: () => import("../pages/AccountPage/ChangePassword/ChangePassword.vue"),
               },
            ],
         },
         {
            path: "/verify-email",
            component: () => import("../pages/Auth/VerifyEmail.vue"),
            name: "verifyEmail",
            meta: {
               requiresAuth: true,
               hideFooter: true,
               hideNavbar: true,
            },
         },
         {
            path: "/delete-account",
            component: () => import("../pages/DeleteAccount/index.vue"),
            name: "deleteAccount",
            meta: {
               requiresAuth: true,
            },
            beforeEnter: (to, from, next) => {
               if (useStore().getters["auth/getUser"] && to.path === "/delete-account") {
                  next();
               }
            },
         },
      ],
   },
];

export default app;
