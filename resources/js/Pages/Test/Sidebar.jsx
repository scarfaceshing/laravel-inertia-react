import React, { useState } from 'react';

const Sidebar = () => {
  const [collapsedItem, setCollapsedItem] = useState(null);

  const handleItemClick = key => {
    if (collapsedItem === key) {
      setCollapsedItem(null); // Toggle collapse for the clicked item
    } else {
      setCollapsedItem(key);
    }
  };

  return (
    <div className="sidebar">
      <ChildComponent key="1" title="Item 1" collapsedItem={collapsedItem} onItemClick={handleItemClick} />
      <ChildComponent key="2" title="Item 2" collapsedItem={collapsedItem} onItemClick={handleItemClick} />
      {/* Add more child components as needed */}
    </div>
  );
};

const ChildComponent = ({ title, key, collapsedItem, onItemClick }) => {
  const isCollapsed = collapsedItem === key;

  return (
    <div className={`item ${isCollapsed ? 'collapsed' : ''}`}>
      <div className="item-header" onClick={() => onItemClick(key)}>
        {title}
        <div className="collapse-icon">{isCollapsed ? '▼' : '▲'}</div>
      </div>
      <div className="item-content">Content for {title}</div>
    </div>
  );
};

export default Sidebar;
