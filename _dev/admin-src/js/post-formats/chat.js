class ChatApp extends React.Component {


  constructor(props) {
    super(props);

    this.state = { items: this.props.messages, text: '', authorID: '1', authors: this.props.authors};
    this.addItem = this.addItem.bind(this);
    this.removeItem = this.removeItem.bind(this);
    this.updateAuthors = this.updateAuthors.bind(this);
  }


  // add a new item
  addItem(newItem) {

    newItem.authorID = newItem.authorID ? newItem.authorID : '1';

    if(newItem.insertItem) {
      var items = window.items = this.state.items;
      var index = parseInt(newItem.index);

      items.splice(index+1, 0, newItem);

      this.setState({
        items: items,
        text: '',
        authorID: ''
      });

    } else {
      this.setState({
          items: this.state.items.concat(newItem),
          text: '',
          authorID: ''
        });

    }

  }

  // update the author names when the author fields change
  updateAuthors(e) {
    
    e.preventDefault();
    const name = e.target.value;
    const num = parseInt(e.target.dataset.authorNum);
    var authors = this.state.authors;
    authors[num] = name;
    this.setState({
      authors: authors
    });

  }
 // remove an item from the log
  removeItem (index) {

    var items = this.state.items;
    items.splice(index, 1)
    this.setState({items: items});
  }


  // render the form
  render() {

    return React.createElement(
      'div', null,
      React.createElement(AuthorNames, {updateAuthors:this.updateAuthors, authors:this.state.authors}),
      React.createElement(ChatHeader, {title:'send new message:'}),
      React.createElement(ChatForm, { addItem:this.addItem, authors:this.state.authors, insertItem:false }),
      React.createElement(ChatHeader, {title:'Chat Log:'}),
      React.createElement(ChatList, { items: this.state.items, removeItem:this.removeItem, authors:this.state.authors, addItem:this.addItem }),
    );
  }

}

/**
* Set the author
*/
class AuthorNames extends React.Component {
  constructor(props) {
    super(props);
  }

  render() {
    var html = '';
    var fieldAuthorNames = 'post_format_chat[authors]';
    return React.createElement('div', {className:'authors-form cf'},
      React.createElement('input', {name:fieldAuthorNames, value: [this.props.authors[1], this.props.authors[2],], type:'hidden'}),
      React.createElement('div', null,
        React.createElement('label', null, 'Author 1'),
        React.createElement('input', {onChange: this.props.updateAuthors, 'data-author-num': 1, value: this.props.authors[1]}) ),
      React.createElement('div', null,
        React.createElement('label', null, 'Author 2'),
        React.createElement('input', {onChange: this.props.updateAuthors, 'data-author-num': 2, value: this.props.authors[2]})
      )
    );
  }
}
/**
*  Display a header element with specified content
*/
class ChatHeader extends React.Component {
  constructor(props){
    super(props);
  }
  render () {
    return React.createElement('h1', null, this.props.title)
  }
}

/**
* The Chat form
*/
class ChatForm extends React.Component {
  constructor(props) {
    super(props);

    this.state = { authorID: '', text: ''};
    this.handleChange = this.handleChange.bind(this);
    this.onSubmit = this.onSubmit.bind(this);
  }

  // when the form is submitted
  onSubmit(e) {
    e.preventDefault();
    var newMsg = {
      authorID: this.state.authorID,
      text: this.state.text,
      id: Date.now(),
      insertItem: this.props.insertItem
    };

    if(this.props.insertItem && this.props.index){
      newMsg.index = this.props.index
    }
    this.props.addItem(newMsg);
    this.setState({
      text:''
    })
  }

  // when the field changes, update the appropriate state prop
  handleChange(e) {
    const target = e.target;
    const value = target.value;
    const name = target.name;

    this.setState({
      [name]: value
    });

  }

  render() {

    //the form is a select for the author, the text field for the message, and the submit button
    return React.createElement(
        'form',
        { onSubmit: this.onSubmit, className:'new-message-form cf' },
        React.createElement(
          'div', null,
          React.createElement('label', null, 'Name'),
          React.createElement('select', { name:'authorID', onChange: this.handleChange, value: this.state.authorID },
            React.createElement('option', { value: 1 }, this.props.authors[1]),
            React.createElement('option', { value: 2 }, this.props.authors[2])

          )
        ),
        React.createElement(
          'div', null,
          React.createElement('label', null, 'Text'),
          React.createElement('input', { name:'text', onChange: this.handleChange, value: this.state.text})
        ),
        React.createElement('button', null, 'Add message')
    );
  }

}

/**
*  Render the submitted items
*/
class ChatList extends React.Component {

  constructor(props) {
    super(props);
  }

  render() {
    // var items = this.props.items.map( (item, index) => React.createElement(
    //   ChatItem, {item: item, index:index, key:index, removeItem:this.props.removeItem, authors:this.props.authors, addItem:this.props.addItem}
    // ) );
    // 
    var items = this.props.items.map( function(item, index) {
      React.createElement(
        ChatItem, {item: item, index:index, key:index, removeItem:this.props.removeItem, authors:this.props.authors, addItem:this.props.addItem}
      );
    });
    return React.createElement('ul', {className: 'chat-log'}, items);
  }


}

/**
* The individual item
*/
class ChatItem extends React.Component {
  constructor(props) {
    super(props);
    this.state = { showField: false };
    this.removeThis = this.removeThis.bind(this);
    this.addMsg = this.addMsg.bind(this);
    this.hideInsertMsg = this.hideInsertMsg.bind(this);
    this.insertItem = this.insertItem.bind(this);
  }

  //intercept the newly add item to hide the field before passing it up the chain
  insertItem(newItem) {
    this.state.showField = false;
    this.props.addItem(newItem);
  }

  // show the insert message field
  addMsg(e) {
    e.preventDefault();
    this.setState({ showField: true });
  }

  // remove the message field (hide it)
  hideInsertMsg(e){
    e.preventDefault();
    this.setState({showField: false});
  }

  // remove the message from the log
  removeThis(e) {
    e.preventDefault();
    this.props.removeItem( parseInt(this.props.index));
  }

  render() {

    var displayName = this.props.authors[parseInt(this.props.item.authorID)];
    var className = 'message message--author-'+this.props.item.authorID;

    var fieldAuthor = 'post_format_chat[messages]['+this.props.index+'][authorID]';
    var fieldDisplayName = 'post_format_chat[messages]['+this.props.index+'][displayName]';
    var fieldText = 'post_format_chat[messages]['+this.props.index+'][text]';

    return React.createElement(
      'li',
      {className: className, key: this.props.index, id:this.props.index},
      React.createElement('input', {type:'hidden', name:fieldAuthor, value:this.props.item.authorID}),
      React.createElement('input', {type:'hidden', name:fieldDisplayName, value:displayName}),
      React.createElement('input', {type:'hidden', name:fieldText, value:this.props.item.text}),
      React.createElement('h5', {className: 'message__author' }, displayName ),
      React.createElement('div', {className: 'message__text'},
        React.createElement('p', null, this.props.item.text),
        React.createElement('div', {className:'message__actions'},
            React.createElement('a', {className:'dashicons dashicons-plus-alt', href:'#', onClick:this.addMsg}),
            React.createElement('a', {className:'dashicons dashicons-dismiss',href:'#', onClick:this.removeThis})
        ),
      ),
      (this.state.showField && React.createElement(ChatForm, { addItem:this.insertItem, authors:this.props.authors, insertItem:true, index:this.props.index+'' }) ),
      (this.state.showField && React.createElement('a',{className:'dashicons dashicons-no', href:'#', onClick:this.hideInsertMsg})),
    );
  }

}


var messages = chat.messages ? chat.messages : [];
var authors = {
  1: 'Author 1', 2: 'Author 2'
};

if(chat.authors){
  tmpauthors = chat.authors.split(',');
  authors[1] = tmpauthors[0];
  authors[2] = tmpauthors[1];
}

ReactDOM.render(
  React.createElement(ChatApp, {messages: messages, authors:authors}),
  document.querySelector('#post_format_chat_log')
);
