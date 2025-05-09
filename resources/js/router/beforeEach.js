function nextFactory(context, middleware, index) {
    const nextMiddleware = middleware[index];

    if (!nextMiddleware) {
        return context.next;
    }

    return (...params) => {
        if (params.length > 0) {
            return context.next(...params);
        }
        const nextStep = nextFactory(context, middleware, index + 1);
        return nextMiddleware({ ...context, next: nextStep });
    };
}

const beforeEach = async (to, from, next, router) => {
    document.title = to.meta.title;

    if (!to.meta.middleware) {
        return next();
    }

    const middleware = Array.isArray(to.meta.middleware)
        ? to.meta.middleware
        : [to.meta.middleware];

    const context = { to, from, next, router };
    return middleware[0]({
        ...context,
        next: nextFactory(context, middleware, 1),
    });
};

export default beforeEach;
