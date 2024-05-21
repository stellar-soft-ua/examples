import { h } from 'preact';
import Image from 'utils/image';
import { useRef, useState, useEffect } from 'preact/hooks';
import PlayIcon from 'utils/icon/icon-play.svg';
import PauseIcon from 'utils/icon/icon-pause.svg';
import VimeoPlayer from 'utils/vimeo-player';
import useInView from 'utils/in-view';

const Media = ({
  mediaContentType,
  previewImage,
  sources,
  srcWidths,
  className,
  parentClass,
  controlClass,
  host,
  onClick,
  lazyLoad,
  forceLazyLoad,
  ...props
}) => {
  if (mediaContentType === 'IMAGE') {
    return (
      <div className={parentClass} onClick={() => onClick && onClick()}>
        <Image
          {...previewImage}
          lazyLoad={lazyLoad}
          forceLazyLoad={forceLazyLoad}
          srcWidths={srcWidths}
          classes={className}
        />
      </div>
    );
  }

  if (mediaContentType === 'VIDEO') {
    return (
      <Video
        previewImage={previewImage}
        sources={sources}
        className={className}
        lazyLoad={lazyLoad}
        parentClass={parentClass}
        controlClass={controlClass}
        onClick={onClick}
        {...props}
      />
    );
  }

  if (mediaContentType === 'EXTERNAL_VIDEO' && host === 'VIMEO') {
    return (
      <VimeoVideo
        previewImage={previewImage}
        originUrl={props.originUrl}
        onClick={onClick}
        lazyLoad={lazyLoad}
        controlClass={controlClass}
        {...props}
      />
    );
  }

  return null;
};

const Video = ({
  previewImage,
  sources,
  className,
  parentClass,
  lazyLoad,
  onClick,
  controlClass = '',
}) => {
  const video = useRef(null);
  const [paused, setPaused] = useState(false);
  const [ref, inView, disconnect] = useInView({ rootMargin: '100px' });
  const [visible, setVisible] = useState(!lazyLoad);

  useEffect(() => {
    if (inView) {
      setVisible(true);
      disconnect();
    }
  }, [inView]);

  const handleClick = () => {
    if (onClick) {
      onClick();
      return;
    }
    toggleVideo();
  };

  const toggleVideo = (e) => {
    e?.preventDefault();
    e?.stopPropagation();
    if (video.current.paused) {
      video.current.play();
    } else {
      video.current.pause();
    }
    setPaused(video.current.paused);
  };

  return (
    <div className={`${parentClass}`} ref={ref}>
      <video
        className={`absolute inset-0 w-full h-full object-cover ${className}`}
        poster={previewImage.url || previewImage.src}
        playsInline
        ref={video}
        loop
        muted
        autoPlay
        onClick={handleClick}
      >
        {visible &&
          sources.map((source, index) => (
            <source
              src={source.url}
              key={index}
              type={`video/${source.format}`}
            />
          ))}
      </video>
      <button
        className={`z-10 absolute left-16 top-16 lc:tablet:bottom-8 
         tablet:top-auto tablet:left-8 ml:tablet:left-16 ml:tablet:bottom-16
         lc:w-36 lc:h-36 ml:w-24 ml:h-24 lc:rounded-full
         bg-white flex items-center justify-center ${controlClass}`}
        onClick={toggleVideo}
        style={{ opacity: 0 }}
      >
        {!paused && <PauseIcon className="w-18 h-auto" />}
        {paused && <PlayIcon className="w-18 h-auto" />}
      </button>
    </div>
  );
};

const VimeoVideo = ({ lazyLoad = true, ...props }) => {
  const [ref, inView, disconnect] = useInView({ rootMargin: '100px' });
  const [visible, setVisible] = useState(false);

  useEffect(() => {
    if (inView) {
      setVisible(true);
      disconnect();
    }
  }, [inView]);

  return (
    <div className="vimeo-video" ref={ref}>
      {(visible || !lazyLoad) && <VimeoPlayer {...props} />}
    </div>
  );
};

export default Media;
