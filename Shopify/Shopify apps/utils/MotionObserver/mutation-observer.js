import { useEffect, useRef, useCallback } from 'preact/hooks';

const useMutationObserver = (target, callback, options = {}) => {
  const observer = useRef(null);

  const stop = useCallback(() => {
    if (!observer.current) return;

    observer.current.disconnect();
    observer.current = null;
  }, []);

  useEffect(() => {
    const el = target.current;

    if (!el) return;

    observer.current = new window.MutationObserver(callback);
    observer.current?.observe(el, options);

    // eslint-disable-next-line consistent-return
    return stop;
  }, [callback, stop, options, target]);

  return {
    stop,
  };
};

export default useMutationObserver;
