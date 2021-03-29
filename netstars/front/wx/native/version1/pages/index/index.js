// index.js
const app = getApp()
// 全局
Page({
  data: {
    records: [], //数组 存放记录
  },

  // js解释器会等到这个代码块的代码都加载完后，在对代码进行预编译，然后执行
  onLoad() {
    let that = this;
    that.getRecords();


  },

  /**
   * 跳转进入新的页面
   */
  navCreate: function () {
    wx.navigateTo({
      url: '/pages/create/index', //创建页面
      success: function (res) {
        console.log('this', this);
      }
    })
  },

  /**
   * 获取数据
   */
  getRecords: function () {
    let that = this;
    wx.request({
      url: 'http://localhost/index.php/Records/getRecords?tmp=1',
      success: function (res) {
        let records = res.data.result;
        that.setData({
          records
        })
      }
    })
  },

  /**
   * 跳转进入详情页
   */
  goDetail: function (e) {
    let that = this;
    console.log('e', e);
    let id = e.currentTarget.dataset.id;
    wx.navigateTo({
      url: '/pages/detail/index?id=' + id,
    })
  }
})