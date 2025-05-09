import { useUserStore } from "@/store/user";

export default function Guest({ next }) {
    const { authenticated, user } = useUserStore();

    if (authenticated) {
        return next({ name: "dashboard" });
    } else return next();
}
