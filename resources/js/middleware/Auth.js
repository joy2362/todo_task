import { useUserStore } from "@/store/user";

export default function Auth({ next }) {
    const { authenticated } = useUserStore();
    console.log("auth");
    if (!authenticated) return next({ name: "login" });
    else return next();
}
