const mongoose = require('mongoose');

const matchSchema = new mongoose.Schema({
  date: {
    type: Date,
    required: true,
  },
  time: {
    type: String,
    required: true,
  },
  opponent: {
    type: String,
    required: true,
    trim: true,
  },
  venue: {
    type: String,
    required: true,
    enum: ['Home', 'Away'],
  },
  result: {
    type: String,
    default: 'Pending',
  },
  status: {
    type: String,
    enum: ['Pending', 'Completed', 'Cancelled'],
    default: 'Pending',
  },
  stats: {
    possession: {
      type: String,
      default: '0%',
    },
    shots: {
      type: Number,
      default: 0,
    },
    shotsOnTarget: {
      type: Number,
      default: 0,
    },
    corners: {
      type: Number,
      default: 0,
    },
    fouls: {
      type: Number,
      default: 0,
    },
  },
  events: [{
    player: {
      type: mongoose.Schema.Types.ObjectId,
      ref: 'Player',
      required: true,
    },
    type: {
      type: String,
      enum: ['goal', 'assist', 'yellow', 'red'],
      required: true,
    },
    minute: {
      type: Number,
      required: true,
      min: 1,
      max: 90,
    },
  }],
  createdAt: {
    type: Date,
    default: Date.now,
  },
  updatedAt: {
    type: Date,
    default: Date.now,
  },
});

// Update the updatedAt timestamp before saving
matchSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('Match', matchSchema); 