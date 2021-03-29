// pages/create/index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },

  /**
   * 设置标题
   */
  fillTitle: function (e) {
    let that = this;
    that.setData({
      title: e.detail.value,
    })
  },

  /**
   * 设置内容
   */
  fillContent: function (e) {
    let that = this;
    that.setData({
      content: e.detail.value,
    })
  },

  /**
   * 保存数据
   */
  saveData: function () {
    let that = this;
    let content = that.data.content;
    let title = that.data.title;
    wx.request({
      url: 'http://localhost/index.php/Records/saveData?tmp=1',
      data: {
        content,
        title
      },
      success: function (res) {
        console.log('res', res);
      }
    })
  }



})