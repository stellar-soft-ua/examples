# useMutationObserver Hook

## Purpose
The `useMutationObserver` hook is a custom React (Preact) hook that provides an easy way to use the `MutationObserver` API in a React component. It allows you to observe changes to a DOM node and execute a callback function when mutations are detected.

## Key Features
- **Observation of DOM Mutations:** Allows observing changes to a specified DOM node.
- **Customizable Options:** Supports passing custom options to the `MutationObserver`.
- **Cleanup:** Ensures proper cleanup of the observer when the component unmounts or dependencies change.

## Example Usage
```javascript
import { h, Fragment } from 'preact';
import { useRef, useState } from 'preact/hooks';
import useMutationObserver from './path/to/useMutationObserver';

const ExampleComponent = () => {
  const targetRef = useRef(null);
  const [mutations, setMutations] = useState([]);

  const callback = (mutationList) => {
    setMutations(mutationList);
  };

  const { stop } = useMutationObserver(targetRef, callback, {
    attributes: true,
    childList: true,
    subtree: true,
  });

  return (
    <Fragment>
      <div ref={targetRef}>Observe me</div>
      <button onClick={stop}>Stop Observing</button>
      <div>
        {mutations.map((mutation, index) => (
          <div key={index}>{mutation.type}</div>
        ))}
      </div>
    </Fragment>
  );
};

export default ExampleComponent;
